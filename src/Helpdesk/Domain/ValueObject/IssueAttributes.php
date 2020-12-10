<?php

namespace App\Helpdesk\Domain\ValueObject;

class IssueAttributes {

    /**
     * @var Priority
     */
    private Priority $priority;
    /**
     * @var Component
     */
    private Component $component;
    private bool      $confidential;

    /**
     * IssueAttributes constructor.
     *
     * @param Priority  $priority
     * @param Component $component
     * @param bool      $confidential
     */
    public function __construct(Priority $priority, Component $component, bool $confidential) {
        $this->priority = $priority;
        $this->component = $component;
        $this->confidential = $confidential;
    }

}