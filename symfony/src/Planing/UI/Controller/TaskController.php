<?php

namespace App\Planing\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Planing\Application\Service\TaskService;
use Exception;

class TaskController extends AbstractController {

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
        $data = json_decode($request->getContent(), TRUE);
        if (!is_array($data)) {
            return $this->json([
                'error' => 'Not valid request',
                'code'  => 400,
            ], Response::HTTP_BAD_REQUEST);

        }

        $data['author'] = $this->getUser()->getId();
        try {
            $uuid = $this->service->createTask($data);
        } catch (Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
                'code'  => $exception->getCode(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['task_id' => $uuid]);
    }

}