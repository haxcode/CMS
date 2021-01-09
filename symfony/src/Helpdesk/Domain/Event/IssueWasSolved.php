<?php

namespace App\Helpdesk\Domain\Event;

use App\Common\Event\Event;
use App\Helpdesk\Domain\Entity\Issue;

class IssueWasSolved implements Event {

    /**
     * @var Issue
     */
    private Issue $issue;

    /**
     * IssueWasSolved constructor.
     *
     * @param Issue $issue
     */
    public function __construct(Issue $issue) {

        $this->issue = $issue;
    }

    /**
     * @return Issue
     */
    public function getIssue(): Issue {
        return $this->issue;
    }

}