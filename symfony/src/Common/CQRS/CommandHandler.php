<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Interface CommandHandler
 *
 * @package App\Common\CQRS
 */
interface CommandHandler extends MessageHandlerInterface {

    /**
     * @param Command $command
     */
    public function __invoke(Command $command): void;

}                                                                                       