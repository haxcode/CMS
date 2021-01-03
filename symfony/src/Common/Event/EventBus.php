<?php

namespace App\Common\Event;

use App\Common\CQRS\Command;

interface EventBus {

    public function raise(Event $event): void;
}