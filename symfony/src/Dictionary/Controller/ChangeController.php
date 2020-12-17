<?php

namespace App\Dictionary\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Dictionary\Repository\ChangeRepository;
use App\Dictionary\Entity\Change;
use Symfony\Component\Uid\Uuid;

class ChangeController extends AbstractController {

    /**
     * @var ChangeRepository
     */
    private ChangeRepository $repository;

    /**
     * ChangeController constructor.
     *
     * @param ChangeRepository $repository
     */
    public function __construct(ChangeRepository $repository) {

        $this->repository = $repository;
    }

    /**
     * @Route(path="/api/dictionary/changes",methods={"POST"},name="dictionary_change_create")
     */
    public function create(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (!isset($data['excerpt']) || !is_string($data['excerpt']) || empty($data['excerpt'])) {
            return $this->json(['error' => 'Change "excerpt" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['description']) || !is_string($data['description']) || empty($data['description'])) {
            return $this->json(['error' => 'Change "description" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }
        $id = Uuid::v4();
        $change = new Change($id, $data['excerpt'], $data['description']);
        $this->repository->create($change);

        return $this->json(['change_id' => (string)$id]);
    }

    /**
     * @Route(path="/api/dictionary/changes/{id}",methods={"GET"},name="dictionary_change_read")
     * @param Request $request
     * @param string  $id
     */
    public function getChange(Request $request, string $id): JsonResponse {
        if (!Uuid::isValid($id)) {
            $this->json(['error' => 'ID of change is not valid identifier'], Response::HTTP_BAD_REQUEST);
        }
        $uuid = new Uuid($id);
        $entity = $this->repository->read($uuid);

        return $this->json($entity);
    }

    /**
     * @Route(path="/api/dictionary/changes",methods={"GET"},name="dictionary_change_list")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getChangesList(Request $request): JsonResponse {

//        $entity = $this->repository->read();

//        return $this->json($entity);

        return $this->json([]);
    }

}