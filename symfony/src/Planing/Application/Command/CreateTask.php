<?php

namespace App\Planing\Application\Command;

use App\Planing\Domain\Entity\Task;
use App\Common\CQRS\Command;

class CreateTask implements Command {

    //@TODO notification will be next intention to implement in this command

    /**
     * @var Task
     */
    private Task $task;

    /**
     * CreateTask constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task) {

        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask(): Task {
        return $this->task;
    }

}