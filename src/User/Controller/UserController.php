<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\User\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;


class UserController extends AbstractFOSRestController {

    /**
     * @Route("/api/admin/users", name="users_list",methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listUsers(Request $request): JsonResponse {

        /** @var User[] $users */
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json($users, Response::HTTP_OK);

    }

}