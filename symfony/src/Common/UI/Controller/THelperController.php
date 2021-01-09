<?php

namespace App\Common\UI\Controller;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

trait THelperController {

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

    public function decodeRequestData(Request $request): ?array {
        $data = json_decode($request->getContent(), TRUE);
        if (!is_array($data)) {
            return NULL;
        }
        return $data;
    }

    public function riseNotValidBodyException(): JsonResponse {
        return new JsonResponse([
            'error' => 'Not valid request',
            'code'  => 400,
        ], Response::HTTP_BAD_REQUEST);
    }

}