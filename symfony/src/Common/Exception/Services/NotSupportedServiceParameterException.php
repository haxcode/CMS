<?php

namespace App\Common\Exception\Services;

use Exception;
use Throwable;

/**
 * Class NotSupportedServiceParameterException
 *
 * @package          App\Common\Exception\Services
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class NotSupportedServiceParameterException extends Exception {

    /**
     * NotSupportedServiceParameterException constructor.
     *
     * @param string         $service
     * @param string         $parameter
     * @param int            $code
     * @param string         $message
     * @param Throwable|null $previous
     */
    public function __construct(string $service, string $parameter, int $code = 4003, string $message = "", Throwable $previous = null) {
        parent::__construct(sprintf('Parameter "%s" is not supported for service %s.', $parameter, $service).$message, $code, $previous);
    }

}