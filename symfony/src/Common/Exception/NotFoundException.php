<?php

namespace App\Common\Exception;

use Exception;
use Throwable;

/**
 * Class NotFoundException
 *
 * @package          App\Common\Exception
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class NotFoundException extends Exception {

    /**
     *
     */
    const NOT_FOUND_EXCEPTION_CODE = 404;

    /**
     * NotFoundException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = self::NOT_FOUND_EXCEPTION_CODE, Throwable $previous = null) {
        $message = empty($message) ? "object not found" : $message;
        parent::__construct($message, $code, $previous);
    }

}