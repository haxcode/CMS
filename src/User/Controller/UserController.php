<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\User\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//use FOS\RestBundle\Controller\AbstractFOSRestController;

class UserController extends AbstractController {

    /**
     * @Route("/api/admin/users", name="users_list")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listUsers(): Response {

        /** @var User[] $users */
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json($users, Response::HTTP_OK);

    }

    /**
     * @Route("/api/admin/users/{id}", name="user_details", methods={"GET"})
     * @param int            $id
     * @param UserRepository $repository
     *
     * @return JsonResponse
     */
    public function getUserDetails(int $id, UserRepository $repository): Response {

        $user = $repository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }
        return $this->json($user, Response::HTTP_OK);
    }

}