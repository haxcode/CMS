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
use App\User\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class CreateIssuesController extends AbstractController {

    private QueryBus   $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus) {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(path="/api/helpdesk/issue",methods={"POST"},name="helpdesk_issue_create")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): Response {
        $data = json_decode($request->getContent(), true);
       
        if (!isset($data['title']) || !is_string($data['title']) || empty($data['title'])) {
            return $this->json(['error' => 'Issue "title" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['description']) || !is_string($data['description']) || empty($data['description'])) {
            return $this->json(['error' => 'Issue "description" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }
        
        if (!isset($data['client']) || !is_string($data['client']) || empty($data['client'])) {
            return $this->json(['error' => 'Issue "client" must be provided as text'], Response::HTTP_BAD_REQUEST);
        }

        $importance = $data['importance'] ?? Importance::NORMALLY;

        if (!Importance::isValid($importance)) {
            return $this->json(['error' => 'Issue "importance" must be provided as one of the values from dictionary'], Response::HTTP_BAD_REQUEST);
        }

        if (isset($data['confidential']) && !is_bool($data['confidential'])) {
            return $this->json(['error' => 'Issue "confidential" must be provided as one of the values from dictionary'], Response::HTTP_BAD_REQUEST);
        }
        $confidential = $data['confidential'] ?? FALSE;

        /** @var  User $this- >getUser() */
        $userID = $this->getUser()->getId();
        $command = new CreateIssue($data['title'], $data['description'], $importance, $confidential, $userID, $data['client']);
        $this->commandBus->dispatch($command);

        return $this->json(['data' => $data]);
    }

}