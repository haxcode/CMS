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
use Exception;
use App\Helpdesk\Application\Service\IssueService;
use App\Common\UI\Controller\THelperController;

class IssuesController extends AbstractController {

    use THelperController;

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
        $data = $this->decodeRequestData($request);
        if (!$data) {
            return $this->riseNotValidBodyException();
        }
        $data['author'] = $this->getUser()->getId();
        try {
            $uuid = $this->service->creatIssue($data);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['issue_id' => $uuid], Response::HTTP_CREATED);
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
            $query = new GetIssueByUuid(new Uuid($uuid), $this->getUser());
            return $this->json(['data' => $this->queryBus->handle($query)], Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * @Route(path="/api/helpdesk/issues/{uuid}/solved",methods={"PATCH"},name="helpdesk_issue_mark_as_solved")
     * @param Request $request
     * @param string  $uuid
     *
     * @return JsonResponse
     */
    public function solveIssue(Request $request, string $uuid): JsonResponse {
        try {
            $result = $this->service->solveIssue($uuid, $this->getUser());
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return $this->json(['success' => $result]);
    }

}