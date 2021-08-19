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
class CreateTaskHandler implements CommandHandler {

    /**
     * @var TaskRepository
     */
    private TaskRepository $repository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * CreateTaskHandler constructor.
     *
     * @param TaskRepository $repository
     * @param EventBus       $eventBus
     */
    public function __construct(TaskRepository $repository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param CreateTask $cm
     */
    public function __invoke(CreateTask $cm): void {

        $this->repository->create($cm->getTask());

    }

}
