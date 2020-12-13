<?php

namespace App\Client\UI\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Common\CQRS\CommandBus;
use App\Common\CQRS\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Client\Application\Command\CreateClient;

class ClientController extends AbstractController {

    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus) {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(path="/api/client", methods={"POST"}, name="client_create")
     * @param Request $request
     */
    public function create(Request $request): JsonResponse {

        $data = json_decode($request->getContent(), TRUE);

        if (!isset($data['nip']) || !is_string($data['nip']) || empty($data['nip'])) {
            return $this->json(['error' => 'Client "nip" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['name']) || !is_string($data['name']) || empty($data['name'])) {
            return $this->json(['error' => 'Client "name" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['short_name']) || !is_string($data['short_name']) || empty($data['short_name'])) {
            return $this->json(['error' => 'Client "short_name" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        $sla = FALSE;
        if (isset($data['sla']) && is_bool($data['sla'])) {
            $sla = $data['sla'];
        }

        $createClient = new CreateClient($data['nip'], $data['name'], $data['short_name'], $sla);
        $this->commandBus->dispatch($createClient);

        return $this->json([], Response::HTTP_CREATED);
    }

}