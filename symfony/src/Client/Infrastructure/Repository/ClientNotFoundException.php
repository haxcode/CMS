<?php

namespace App\Client\Infrastructure\Repository;

use Throwable;
use App\Common\Exception\NotFoundException;

/**
 * Class ClientNotFoundException
 *
 * @package          App\Client\Infrastructure\Repository
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class ClientNotFoundException extends NotFoundException {

    /**
     * ClientNotFoundException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 404, Throwable $previous = null) {
        $message = empty($message) ? "Client not found" : $message;
        parent::__construct($message, $code, $previous);
    }

}