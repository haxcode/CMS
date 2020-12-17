<?php

namespace App\Helpdesk\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Helpdesk\Infrastructure\Repository\IssueRepository")
 */
class Issue {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid",name="issue_id")
     */
    private Uuid $issueId;

    /**
     * @return Uuid
     */
    public function getIssueId(): Uuid {
        return $this->issueId;
    }

}