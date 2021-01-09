<?php

namespace App\Planing\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Planing\Application\Service\TaskService;
use Exception;
use App\Common\UI\Controller\THelperController;
use Symfony\Component\HttpFoundation\Response;
use App\Common\CQRS\QueryBus;
use App\Planing\Application\Query\GetTaskByUuid;
use Symfony\Component\Uid\Uuid;

class TaskController extends AbstractController {

    use THelperController;

    /**
     * @var TaskService
     */
    private TaskService $service;
    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    /**
     * TaskController constructor.
     *
     * @param TaskService $service
     * @param QueryBus    $queryBus
     */
    public function __construct(TaskService $service, QueryBus $queryBus) {
        $this->service = $service;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route(path="/api/plan/tasks", methods={"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createTask(Request $request): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }

        $data['author'] = $this->getUser()->getId();
        try {
            $uuid = $this->service->createTask($data);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['task_id' => $uuid], Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/api/plan/tasks/{uuid}", methods={"PATCH"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function updateTask(Request $request, string $uuid): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }

        $data['task_id'] = $uuid;
        try {
            $this->service->updateTask($data, $this->getUser());
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/plan/tasks/{uuid}", methods={"GET"})
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function getTask(Request $request, string $uuid): JsonResponse {
        try {
            $data = $this->queryBus->handle(new GetTaskByUuid(new Uuid($uuid), $this->getUser()));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['data' => $data], Response::HTTP_OK);
    }

}