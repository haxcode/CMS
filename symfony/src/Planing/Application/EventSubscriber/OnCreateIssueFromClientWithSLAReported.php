<?php

namespace App\Planing\Application\EventSubscriber;

use App\Helpdesk\Domain\Event\CreatedIssueFromClientWithSLAReported;
use App\Common\Event\EventHandler;
use App\Planing\Domain\Entity\Task;
use Symfony\Component\Uid\Uuid;
use App\Planing\Domain\ValueObject\Status;
use App\Common\CQRS\CommandBus;
use App\Planing\Application\Command\CreateTask;

/**
 * Class OnCreateIssueFromClientWithSLAReported
 *
 * @package          App\Planing\Application\EventSubscriber
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class OnCreateIssueFromClientWithSLAReported implements EventHandler {

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * OnCreateIssueFromClientWithSLAReported constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    /**
     * @param CreatedIssueFromClientWithSLAReported $event
     */
    public function __invoke(CreatedIssueFromClientWithSLAReported $event) {

        // in reaction to add sla issue our team need to have assigned task in current sprint to investigate this issue

        $taskID = Uuid::v4();
        $task = new Task($taskID, 'Investigate: '.$event->getIssueTitle(), new Status(Status::WEEKLY), $event->getIssuer(), NULL, $event->getClient()->getId());
        $task->setRelatedTo($event->getIssueID());
        $this->commandBus->dispatch(new CreateTask($task));
    }

}