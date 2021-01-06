<?php

namespace App\Planing\Infrastructure\CommandHandler;

use App\Planing\Infrastructure\Repository\TaskRepository;
use App\Common\Event\EventBus;
use App\Common\CQRS\CommandHandler;
use App\Planing\Application\Command\CreateTask;

/**
 * Class CreateTaskHandler
 *
 * @package          App\Planing\Infrastructure\CommandHandler
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class CreateTaskHandler implements CommandHandler {

    public function __construct(TaskRepository $repository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param CreateIssue $cm
     */
    public function __invoke(CreateTask $cm): void {

        $client = $this->clientRepository->find($cm->getClient());
        $issueID = Uuid::v4();
        $issue = new Issue($issueID, $client, $cm->getComponent(), $cm->getTitle(), $cm->getDescription(), $cm->getAuthor(), (string)$cm->getImportance(), $cm->getConfidential());
        $this->repository->create($issue);

    }

}
