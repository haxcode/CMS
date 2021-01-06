<?php

namespace App\Planing\Application\EventSubscriber;

use App\Helpdesk\Domain\Event\CreatedIssueFromClientWithSLAReported;
use App\Common\Event\EventHandler;

class OnCreateIssueFromClientWithSLAReported implements EventHandler {


    public function __invoke(CreatedIssueFromClientWithSLAReported $event) {

        var_dump('heueausuuea');
    
    }


}