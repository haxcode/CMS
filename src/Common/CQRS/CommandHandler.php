<?php

declare(strict_types=1);

namespace App\Common\CQRS;

/**
 * Interface CommandHandler
 *
 * @package App\Common\CQRS
 */
interface CommandHandler {

    /**
     * @param Command $command
     */
    public function dispatch(Command $command): void;

}                                                                                       