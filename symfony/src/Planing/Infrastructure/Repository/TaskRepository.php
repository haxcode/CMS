<?php

namespace App\Planing\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Planing\Domain\Entity\Task;

class TaskRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Task::class);
    }

    public function create(Task $task): void {
        $task->stampCreate();
        $this->_em->persist($task);
        $this->_em->flush();
    }

    public function update(Task $task): void {
        $task->stampModified();
        $this->_em->persist($task);
        $this->_em->flush();
    }

}