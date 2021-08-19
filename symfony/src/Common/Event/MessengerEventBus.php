<?php

declare(strict_types=1);

namespace App\Common\Event;

use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerEventBus
 *
 * @package          App\Common\Event
 * @createDate       2021-01-03
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class MessengerEventBus implements EventBus {

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $eventBus;

    /**
     * MessengerCommandBus constructor.
     *
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus) {
        $this->eventBus = $commandBus;
    }

    /**
     * @param Event $event
     */
    public function raise(Event $event): void {
        $this->eventBus->dispatch($event);
    }

}