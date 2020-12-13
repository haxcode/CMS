<?php

namespace App\Client\Domain\Exception;

use Exception;
use Throwable;

class ClientWithThisNIPAlreadyExist extends Exception {

    public function __construct($message = "Client with this NIP already exist", $code = 0, Throwable $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }

}