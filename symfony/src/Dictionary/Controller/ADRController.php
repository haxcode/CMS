<?php

namespace App\Dictionary\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Dictionary\Service\ADRService;
use App\Common\UI\Controller\THelperController;
use Symfony\Component\Uid\Uuid;

class ADRController extends AbstractController {

    use THelperController;

    /**
     * @var ADRService
     */
    private ADRService $service;

    /**
     * ADRController constructor.
     *
     * @param ADRService $service
     */
    public function __construct(ADRService $service) {
        $this->service = $service;
    }

    /**
     * @Route(path="/api/dictionary/adr",methods={"POST"},name="dictionary_adr_create")
     */
    public function create(Request $request): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }
        $user = $this->getUser();
        try {
            $uuid = $this->service->createADR($data, $user);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['ard_uuid' => $uuid], Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/api/dictionary/adr/{uuid}",methods={"GET"},name="dictionary_adr_read")
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function getArchitectureDecisionRecord(Request $request, string $uuid): JsonResponse {
        try {
            $entity = $this->service->getADR(new Uuid($uuid));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
        return $this->json($entity, Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/dictionary/adr",methods={"GET"},name="dictionary_change_list")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse {
        try {
            $entities = $this->service->getAll();
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
        return $this->json($entities, Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/dictionary/adr/{uuid}",methods={"PATCH"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function update(Request $request, string $uuid): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }
        $data['uuid'] = $uuid;
        try {
            $this->service->updateADR($data, $user = $this->getUser());
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json([], Response::HTTP_OK);

    }

    /**
     * @Route(path="/api/dictionary/adr/{uuid}",methods={"DELETE"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function delete(Request $request, string $uuid): JsonResponse {
        try {
            $this->service->deleteADR(new Uuid($uuid));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
        return $this->json([], Response::HTTP_OK);
    }

}