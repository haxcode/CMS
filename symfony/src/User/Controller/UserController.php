<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController {

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(UserRepository $userRepository, Security $security) {

        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    /**
     * @Route("/api/admin/users", name="users_list")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listUsers(): Response {

        $users = $this->userRepository->findAll();

        return $this->json($users, Response::HTTP_OK);

    }

    /**
     * @Route("/api/admin/users/{id}", name="user_details", methods={"GET"})
     * @param int            $id
     * @param UserRepository $repository
     *
     * @return JsonResponse
     */
    public function getUserDetails(int $id): Response {

        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['error' => 'No user found for id '.$id], Response::HTTP_NOT_FOUND);
        }
        return $this->json($user, Response::HTTP_OK);
    }

    /**
     * @Route("/api/userprofile", name="user_profile_details", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getUserProfileDetails(Request $request): Response {
        $user = $this->userRepository->find($this->security->getUser()->getId());
        if (!$user) {
            return $this->json(['error' => 'Your session expired'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($user, Response::HTTP_OK);
    }

}