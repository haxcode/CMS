<?php

namespace App\Common\Exception;

use Exception;
use Throwable;

class NotSupportedType extends Exception {

    public function __construct($message = "Not supported type", Throwable $previous = NULL) {
        parent::__construct($message, 404, $previous);
    }

}