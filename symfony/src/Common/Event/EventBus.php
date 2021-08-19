<?php

namespace App\Common\Event;

interface EventBus {

    public function raise(Event $event): void;

}