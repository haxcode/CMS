<?php

namespace App\Common\Exception\Access;

use Exception;
use Throwable;

class ObjectAccessException extends Exception {

    protected string $object;

    /**
     * ObjectAccessException constructor.
     *
     * @param string         $object
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $object, string $message = "", $code = 403, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->object = $object;
    }

    /**
     * @return string
     */
    public function getObject(): string {
        return $this->object;
    }

}