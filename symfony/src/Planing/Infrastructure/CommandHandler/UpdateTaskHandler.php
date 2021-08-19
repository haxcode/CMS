<?php

namespace App\Planing\Infrastructure\CommandHandler;

use App\Planing\Infrastructure\Repository\TaskRepository;
use App\Common\Event\EventBus;
use App\Common\CQRS\CommandHandler;
use App\Planing\Application\Command\UpdateTask;
use Symfony\Component\Uid\Uuid;
use App\Common\Exception\NotFoundException;
use App\Client\Infrastructure\Repository\ClientRepository;
use App\Planing\Domain\ValueObject\Status;
use App\Helpdesk\Infrastructure\Repository\IssueRepository;
use App\Common\Exception\NotSupportedType;
use App\Planing\Domain\Exception\DomainPlaningLogicException;

/**
 * Class UpdateTaskHandler
 *
 * @package          App\Planing\Infrastructure\CommandHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class UpdateTaskHandler implements CommandHandler {

    /**
     * @var TaskRepository
     */
    private TaskRepository $repository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;
    /**
     * @var IssueRepository
     */
    private IssueRepository $issueRepository;

    /**
     * CreateTaskHandler constructor.
     *
     * @param TaskRepository   $repository
     * @param ClientRepository $clientRepository
     * @param IssueRepository  $issueRepository
     * @param EventBus         $eventBus
     */
    public function __construct(TaskRepository $repository, ClientRepository $clientRepository, IssueRepository $issueRepository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
        $this->clientRepository = $clientRepository;
        $this->issueRepository = $issueRepository;
    }

    /**
     * @param UpdateTask $c
     *
     * @throws NotFoundException
     * @throws NotSupportedType
     * @throws DomainPlaningLogicException
     */
    public function __invoke(UpdateTask $c): void {

        $task = $this->repository->find(new Uuid($c->getData()['task_id']));
        if (!$task) {
            throw new NotFoundException('Task with this uuid was not found.');
        }

        if ($c->isChanged('description')) {
            $task->setDescription($c->getData()['description']);
        }

        if ($c->isChanged('assigned')) {
            $task->setAssigned($c->getData()['assigned']);
        }
        if ($c->isChanged('client')) {
            $client = $this->clientRepository->find(new Uuid($c->getData()['client']));
            if (!$client) {
                throw new NotFoundException('Cant relate task to that client. Client with this uuid was not found.');
            }
            $task->setClientID($client->getId());
        }

        if ($c->isChanged('state')) {
            $task->setState(new Status($c->getData()['state']));
        }

        if ($c->isChanged('related_to')) {
            $issue = $this->issueRepository->find($c->getData()['related_to']);
            if (!$issue) {
                throw new NotFoundException('Cant relate task to that issue. Issue with this uuid was not found.');
            }
            $task->setRelatedTo($c->getData()['related_to']);
        }

        if ($c->isChanged('estimated_time')) {
            $task->setEstimatedTime($c->getData()['estimated_time']);
        }

        if ($c->isChanged('spend_time')) {
            $task->setSpendTime($c->getData()['spend_time']);
        }

        if ($c->isChanged('note')) {
            $task->setNote($c->getData()['note']);
        }

        $task->setModifier($c->getUser()->getId());
        $this->repository->update($task);

    }

}
