<?php

namespace App\Common\Exception\Services;

use Exception;
use Throwable;

/**
 * Class ServiceTypeParameterException
 *
 * @package          App\Common\Exception\Services
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class ServiceTypeParameterException extends Exception {

    /**
     * ServiceTypeParameterException constructor.
     *
     * @param                $service
     * @param                $parameter
     * @param                $type
     * @param int            $code
     * @param string         $message
     * @param Throwable|null $previous
     */
    public function __construct(string $service, string $parameter, string $type, int $code = 4002,string $message = "", Throwable $previous = null) {
        $message = empty($message) ? : $message;
        parent::__construct(sprintf('Parameter "%s" for service %s must be type of %s. ', $parameter, $service, $type).$message, $code, $previous);
    }

}