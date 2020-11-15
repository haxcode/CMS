<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController {

    /**
     * @Route(path="/api/login", methods={"POST"},name="login")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse {

        $password = $request->get('password');
        $login = $request->get('login');

        return $this->json([
            'pass'  => $password,
            'login' => $login,
        ], Response::HTTP_OK);
    }

}