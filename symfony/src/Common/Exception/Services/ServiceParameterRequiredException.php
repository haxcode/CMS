<?php

namespace App\Common\Exception\Services;

use Exception;
use Throwable;

/**
 * Class ParameterRequiredException
 *
 * @package          App\Common\Exception\Services
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class ServiceParameterRequiredException extends Exception {

    /**
     * ParameterRequiredException constructor.
     *
     * @param                $service
     * @param                $parameter
     * @param int            $code
     * @param string         $message
     * @param Throwable|null $previous
     */
    public function __construct(string $service, string $parameter, int $code = 4001, string $message = "", Throwable $previous = null) {
        $message = empty($message) ? : $message;
        parent::__construct(sprintf('Parameter "%s" is required by service %s. ', $parameter, $service).$message, $code, $previous);
    }

}