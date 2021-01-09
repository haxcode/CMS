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

class TaskController extends AbstractController {

    use THelperController;

    /**
     * @var TaskService
     */
    private TaskService $service;

    /**
     * TaskController constructor.
     *
     * @param TaskService $service
     */
    public function __construct(TaskService $service) {

        $this->service = $service;
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

}