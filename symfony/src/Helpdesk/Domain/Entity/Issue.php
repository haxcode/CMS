<?php

namespace App\Helpdesk\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\UUID;

/**
 * @ORM\Entity(repositoryClass="App\Helpdesk\Infrastructure\Repository\IssueRepository")
 */
class Issue {

    /**
     * @ORM\Id
     * @ORM\Column(type="string",name="issue_id")
     */
    private UUID $issueId;

    /**
     * @return UUID
     */
    public function getIssueId(): UUID {
        return $this->issueId;
    }

}