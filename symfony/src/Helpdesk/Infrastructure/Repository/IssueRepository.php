<?php

namespace App\Helpdesk\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Helpdesk\Domain\Entity\Issue;

class IssueRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Issue::class);
    }

    public function create(Issue $issue): void {
        $issue->stampCreate();
        $this->_em->persist($issue);
        $this->_em->flush();
    }

}