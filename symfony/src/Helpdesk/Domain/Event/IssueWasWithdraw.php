<?php

namespace App\Helpdesk\Domain\Event;

use App\Helpdesk\Domain\Entity\Issue;
use App\Common\Event\Event;

class IssueWasWithdraw implements Event {

    /**
     * @var Issue
     */
    private Issue $issue;

    /**
     * IssueWasWithdraw constructor.
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