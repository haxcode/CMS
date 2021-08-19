<?php

namespace App\Planing\Application\Service;

use Symfony\Component\Uid\Uuid;
use App\Planing\Domain\ValueObject\Status;
use App\Common\Service\TServiceParameterValidator;
use App\Common\Exception\Services\ServiceTypeParameterException;
use App\Common\CQRS\CommandBus;
use App\Planing\Application\Command\CreateTask;
use App\Planing\Domain\Entity\Task;
use App\Common\Exception\NotSupportedType;
use App\Common\Exception\Services\ServiceParameterRequiredException;
use App\Common\Exception\Services\NotSupportedServiceParameterException;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Planing\Application\Command\UpdateTask;

class TaskService {

    use TServiceParameterValidator;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * TaskService constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus) {
        $this->serviceName = 'TaskService';
        $this->commandBus = $commandBus;
    }

    /**
     * @param array $data
     *
     * @return Uuid
     * @throws ServiceTypeParameterException
     * @throws NotSupportedServiceParameterException
     * @throws ServiceParameterRequiredException
     * @throws NotSupportedType
     */
    public function createTask(array $data): Uuid {

        $this->validate($data, [
            'description'    => 'required|text',
            'client'         => 'required|uuid',
            'status'         => 'text',
            'assigned'       => 'int',
            'related_to'     => 'uuid',
            'estimated_time' => 'string',
            'note'           => 'string',
            'author'         => 'int',
        ]);

        $status = $data['status'] ?? Status::BACKLOG;
        $id = Uuid::v4();
        $assigned = $data['assigned'] ?? NULL;

        $task = new Task($id, $data['description'], new Status($status), $data['author'], $assigned, $data['client']);

        if (isset($data['related_to'])) {
            $task->setRelatedTo($data['related_to']);
        }

        if (isset($data['estimated_time'])) {
            $task->setEstimatedTime($data['estimated_time']);
        }

        if (isset($data['note'])) {
            $task->setNote($data['note']);
        }

        $command = new CreateTask($task);

        $this->commandBus->dispatch($command);

        return $id;
    }

    /**
     * @param array         $data
     * @param UserInterface $user
     *
     * @throws NotSupportedServiceParameterException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     */
    public function updateTask(array $data, UserInterface $user): void {
        $this->validate($data, [
            'task_id'        => 'required|uuid',
            'description'    => 'text',
            'assigned'       => 'int',
            'client'         => 'uuid',
            'state'          => 'text',
            'related_to'     => 'uuid',
            'estimated_time' => 'string',
            'spend_time'     => 'string',
            'note'           => 'string',
        ]);

        $command = new UpdateTask($data, $user);

        $this->commandBus->dispatch($command);

    }

}