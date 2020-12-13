<?php

namespace App\Client\UI\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Common\CQRS\CommandBus;
use App\Common\CQRS\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends AbstractController {

    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus) {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(path="/api/client", methods={"POST"}, name="client_create")
     * @param Request $request
     */
    public function __invoke(Request $request): JsonResponse {

        $data = [];
        return $this->json($data, Response::HTTP_CREATED);
    }

}