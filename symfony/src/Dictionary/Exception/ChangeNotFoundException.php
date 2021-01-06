<?php

namespace App\Dictionary\Exception;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use App\Common\Exception\NotFoundException;

/**
 * Class ChangeNotFoundException
 *
 * @package          App\Dictionary\Exception
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class ChangeNotFoundException extends NotFoundException {

    /**
     * ChangeNotFoundException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = Response::HTTP_NOT_FOUND, Throwable $previous = null) {
        $message = empty($message) ? "Change not found" : $message;
        parent::__construct($message, $code, $previous);
    }

}