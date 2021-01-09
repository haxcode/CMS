<?php

namespace App\Helpdesk\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Common\CQRS\QueryBus;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use App\Helpdesk\Application\Query\GetIssueByUuid;
use App\Common\Exception\NotFoundException;
use Exception;
use App\Helpdesk\Application\Service\IssueService;

class IssuesController extends AbstractController {

    /**
     * @var IssueService
     */
    private IssueService $service;
    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    public function __construct(IssueService $service, QueryBus $queryBus) {

        $this->service = $service;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route(path="/api/helpdesk/issues",methods={"POST"},name="helpdesk_issue_create")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createIssue(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);
        if (!is_array($data)) {
            return $this->json([
                'error' => 'Not valid request',
                'code'  => 400,
            ], Response::HTTP_BAD_REQUEST);

        }
        $data['author'] = $this->getUser()->getId();
        try {
            $uuid = $this->service->creatIssue($data);
        } catch (Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
                'code'  => $exception->getCode(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['issue_id' => $uuid]);
    }

    /**
     * @Route(path="/api/helpdesk/issues/{uuid}",methods={"GET"},name="helpdesk_issue_get")
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function getIssue(Request $request, string $uuid): JsonResponse {
        if (!Uuid::isValid($uuid)) {
            return $this->json(['error' => 'Issue ID must be a valid string uuid']);
        }
        try {

            $query = new GetIssueByUuid(new Uuid($uuid));
            $data = $this->queryBus->handle($query);
            if (empty($data)) {
                throw new NotFoundException("Issue with specified identity not found");
            }
            return $this->json(['data' => $data], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

}