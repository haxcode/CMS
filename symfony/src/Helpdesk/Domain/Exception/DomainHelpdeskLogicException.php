<?php

namespace App\Helpdesk\Domain\Exception;

use Exception;
use Throwable;

class DomainHelpdeskLogicException extends Exception {

    public function __construct($message = "Domain logic exception", $code = 400, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}