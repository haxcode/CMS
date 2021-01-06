<?php

namespace App\Helpdesk\Infrastructure\CommandHandler;

use App\Helpdesk\Application\Command\CreateIssue;
use App\Helpdesk\Infrastructure\Repository\IssueRepository;
use App\Helpdesk\Domain\Entity\Issue;
use Symfony\Component\Uid\Uuid;
use App\Client\Infrastructure\Repository\ClientRepository;
use App\Common\Event\EventBus;
use App\Helpdesk\Domain\Event\CreatedIssueFromClientWithSLAReported;
use DateTime;
use App\Common\CQRS\CommandHandler;

/**
 * Class CreateIssueHandler
 *
 * @package          App\Helpdesk\Infrastructure\CommandHandler
 * @createDate       2020-12-13
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class CreateIssueHandler implements CommandHandler {

    /**
     * @var IssueRepository
     */
    private IssueRepository $repository;
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    public function __construct(IssueRepository $repository, ClientRepository $clientRepository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->clientRepository = $clientRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param CreateIssue $cm
     */
    public function __invoke(CreateIssue $cm): void {

        $client = $this->clientRepository->find($cm->getClient());
        $issueID = Uuid::v4();
        $issue = new Issue($issueID, $client, $cm->getComponent(), $cm->getTitle(), $cm->getDescription(), $cm->getAuthor(), (string)$cm->getImportance(), $cm->getConfidential());
        $this->repository->create($issue);
        if ($client->hasSla()) {
            $event = new CreatedIssueFromClientWithSLAReported($issueID, $cm->getDescription(), $client, $cm->getImportance(), new DateTime());
            $this->eventBus->raise($event);
        }

    }

}
