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
     * @Route(path="/api/plan/release", methods={"POST"})
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
    

}