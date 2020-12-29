<?php

namespace App\Dictionary\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use App\Dictionary\Repository\ComponentRepository;
use App\Dictionary\Entity\Component;
use Doctrine\ORM\NonUniqueResultException;

class ComponentController extends AbstractController {

    /**
     * @var ComponentRepository
     */
    private ComponentRepository $repository;

    /**
     * ComponentController constructor.
     *
     * @param ComponentRepository $repository
     */
    public function __construct(ComponentRepository $repository) {

        $this->repository = $repository;
    }

    /**
     * @Route(path="/api/dictionary/components",methods={"POST"},name="dictionary_component_create")
     */
    public function create(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (!isset($data['name']) || !is_string($data['name']) || empty($data['name'])) {
            return $this->json(['error' => 'Component "name" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['description']) || !is_string($data['description']) || empty($data['description'])) {
            return $this->json(['error' => 'Component "description" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }
        $id = Uuid::v4();
        $component = new Component($id, $data['name'], $data['description']);
        $this->repository->create($component);

        return $this->json(['component_id' => (string)$id]);
    }

    /**
     * @Route(path="/api/dictionary/components/{uuid}",methods={"GET"},name="dictionary_component_read")
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function getComponent(Request $request, string $uuid): JsonResponse {
        if (!Uuid::isValid($uuid)) {
            $this->json(['error' => 'ID of component is not valid identifier'], Response::HTTP_BAD_REQUEST);
        }
        $uuid = new Uuid($uuid);
        $entity = $this->repository->get($uuid);

        return $this->json($entity);
    }

    /**
     * @Route(path="/api/dictionary/components",methods={"GET"},name="dictionary_component_list")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getComponentList(Request $request): JsonResponse {

        $entities = $this->repository->findAll();

        return $this->json($entities);
    }

    /**
     * @Route(path="/api/dictionary/components/{uuid}",methods={"PATCH"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function updateComponent(Request $request, string $uuid): JsonResponse {
        if (!Uuid::isValid($uuid)) {
            $this->json(['error' => 'ID of component is not valid identifier'], Response::HTTP_BAD_REQUEST);
        }
        $data = json_decode($request->getContent(), TRUE);

        $uuid = new Uuid($uuid);
        /** @var Component $component */
        $component = $this->repository->get($uuid);
        if (isset($data['description']) && is_string($data['description'])) {
            $component->setDescription($data['description']);
        }
        if (isset($data['name']) && is_string($data['name'])) {
            $component->setName($data['name']);
        }

        $this->repository->update($component);
        return $this->json(['uuid' => (string)$uuid]);
    }

    /**
     * @Route(path="/api/dictionary/components/{uuid}",methods={"DELETE"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function deleteComponent(Request $request, string $uuid): JsonResponse {
        if (!Uuid::isValid($uuid)) {
            $this->json(['error' => 'ID of component is not valid identifier'], Response::HTTP_BAD_REQUEST);
        }

        $uuid = new Uuid($uuid);

        try {
            $this->repository->delete($uuid);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], $exception->getCode());
        }
        return new JsonResponse(NULL, 200);
    }

}