<?php

namespace App\Client\Domain\Exception;

use Exception;
use Throwable;

class NotValidNIP extends Exception {

    public function __construct($message = "Not valid NIP detected", $code = 0, Throwable $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }

}