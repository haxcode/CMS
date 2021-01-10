<?php

namespace App\Planing\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;
use App\Common\UI\Controller\THelperController;
use Symfony\Component\HttpFoundation\Response;
use App\Common\CQRS\QueryBus;
use App\Planing\Application\Service\ReleaseService;
use App\Planing\Application\Query\GetReleaseByUuid;
use Symfony\Component\Uid\Uuid;
use App\Planing\Application\Query\GetReleases;

class ReleaseController extends AbstractController {

    use THelperController;

    /**
     * @var ReleaseService
     */
    private ReleaseService $service;
    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    /**
     * ReleaseController constructor.
     *
     * @param ReleaseService $service
     * @param QueryBus       $queryBus
     */
    public function __construct(ReleaseService $service, QueryBus $queryBus) {
        $this->service = $service;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route(path="/api/plan/releases", methods={"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createRelease(Request $request): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }

        $user = $this->getUser();
        try {
            $uuid = $this->service->createRelease($data, $user);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['release_uuid' => $uuid], Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/api/plan/releases/{uuid}", methods={"PATCH"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function updateRelease(Request $request, string $uuid): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }
        $data['release_id'] = $uuid;
        $user = $this->getUser();
        try {
            $this->service->updateRelease($data, $user);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/plan/releases/{uuid}", methods={"GET"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function getRelease(Request $request, string $uuid): JsonResponse {

        $user = $this->getUser();
        try {
            $result = $this->queryBus->handle(new GetReleaseByUuid(new Uuid($uuid), $user));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['data' => $result], Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/plan/releases", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListReleases(Request $request): JsonResponse {

        $user = $this->getUser();
        try {
            $result = $this->queryBus->handle(new GetReleases($user));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['data' => $result], Response::HTTP_OK);
    }

}