<?php

namespace App\Helpdesk\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpdesk\Application\Command\CreateIssue;
use App\Common\CQRS\QueryBus;
use App\Common\CQRS\CommandBus;
use App\Helpdesk\Domain\ValueObject\Importance;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use App\Helpdesk\Application\Query\GetIssueByUuid;
use App\Common\Exception\NotFoundException;

class IssuesController extends AbstractController {

    private QueryBus   $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus) {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(path="/api/helpdesk/issues",methods={"POST"},name="helpdesk_issue_create")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (!isset($data['title']) || !is_string($data['title']) || empty($data['title'])) {
            return $this->json(['error' => 'Issue "title" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['description']) || !is_string($data['description']) || empty($data['description'])) {
            return $this->json(['error' => 'Issue "description" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['client']) || !is_string($data['client']) || empty($data['client'])) {
            return $this->json(['error' => 'Issue "client" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }
        if (!isset($data['component']) || !is_string($data['component']) || empty($data['component'])) {
            return $this->json(['error' => 'Issue "component" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        $importance = $data['importance'] ?? Importance::NORMALLY;

        if (!Importance::isValid($importance)) {
            return $this->json(['error' => 'Issue "importance" must be provided as one of the values from dictionary'], Response::HTTP_BAD_REQUEST);
        }
        $confidential = FALSE;
        if (isset($data['confidential']) && is_bool($data['confidential'])) {
            $confidential = $data['confidential'];
        }

        $userID = $this->getUser()->getId();
        try {
            $id = Uuid::v4();
            $command = new CreateIssue($id, $data['title'], $data['description'], $importance, (bool)$confidential, $userID, Uuid::fromString($data['client']), Uuid::fromString($data['component']));
            $this->commandBus->dispatch($command);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], $exception->getCode());
        }

        return $this->json(['issue_id' => $id], Response::HTTP_CREATED);
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
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

}