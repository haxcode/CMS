<?php

namespace App\Client\UI\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Common\CQRS\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Client\Application\Query\ClientsList;
use App\Common\UI\Controller\THelperController;
use App\Client\Application\Service\ClientService;
use Exception;

class ClientController extends AbstractController {

    use THelperController;

    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;
    /**
     * @var ClientService
     */
    private ClientService $service;

    public function __construct(ClientService $service, QueryBus $queryBus) {
        $this->queryBus = $queryBus;
        $this->service = $service;
    }

    /**
     * @Route(path="/api/clients", methods={"POST"}, name="client_create")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }

        try {
            $uuid = $this->service->createClient($data);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['client_id' => (string)$uuid], Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/api/clients", methods={"GET"}, name="client_list")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse {

        try {
            $query = new ClientsList();
            $data = $this->queryBus->handle($query);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['data' => $data], Response::HTTP_CREATED);
    }

}