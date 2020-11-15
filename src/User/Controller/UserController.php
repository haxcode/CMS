<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\User\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController {

    /**
     * @Route("/api/users", name="users_list")
     */
    public function listUsers(Request $request): JsonResponse {

        /** @var User[] $users */
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();


        return $this->json($users, Response::HTTP_OK);

    }

}