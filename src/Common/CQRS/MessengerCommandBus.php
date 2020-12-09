<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerCommandBus
 *
 * @package          App\Common\CQRS
 * @createDate       2020-12-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class MessengerCommandBus implements CommandBus {

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $commandBus;

    /**
     * MessengerCommandBus constructor.
     *
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus) {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Command $command
     */
    public function dispatch(Command $command): void {
        $this->commandBus->dispatch($command);
    }

}