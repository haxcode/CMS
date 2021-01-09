<?php

namespace App\Common\UI\Controller;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait TExceptionController {

    /**
     * @param Exception $exception
     */
    public function handleException(Exception $exception): JsonResponse {
        //TODO add logger for errors
        return new JsonResponse([
            'error' => $exception->getMessage(),
            'code'  => $exception->getCode(),
        ], Response::HTTP_BAD_REQUEST);
    }

}