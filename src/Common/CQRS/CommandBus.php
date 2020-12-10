<?php

declare(strict_types=1);

namespace App\Common\CQRS;

/**
 * Interface CommandBus
 *
 * @package App\Common\CQRS
 */
interface CommandBus {

    public function dispatch(Command $command): void;

}