<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\User\Repository\AuthTokenRepository;
use App\User\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\User\Entity\Factory\AuthTokenFactory;

class AuthController extends AbstractController {

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var AuthTokenRepository
     */
    private AuthTokenRepository $authTokenRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserRepository $userRepository, AuthTokenRepository $authTokenRepository, UserPasswordEncoderInterface $passwordEncoder) {
        $this->userRepository = $userRepository;
        $this->authTokenRepository = $authTokenRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route(path="/api/login", methods={"POST"}, name="login")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);
        $login = $data['login'] ?? '';
        $password = $data['password'] ?? '';
        if (!is_string($login) || !is_string($password)) {
            throw new CustomUserMessageAuthenticationException('Provided credential are wrong!', [], 404);
        }

        /** @var User $user */
        $user = $this->userRepository->findByEmail($login);
        if ($user === NULL) {
            throw new CustomUserMessageAuthenticationException('Provided credential are wrong!', [], 404);
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new CustomUserMessageAuthenticationException('Provided credential are wrong!', [], 404);
        }

        $token = AuthTokenFactory::createAuthToken($user);
        $refreshToken = AuthTokenFactory::createRefreshAuthToken($user);
        $refreshToken->setParentId($token->getId());
        $this->authTokenRepository->create($token);
        $this->authTokenRepository->create($refreshToken);
        return $this->json([
            'token'         => $token->getToken(),
            'refresh_token' => $refreshToken->getToken(),
        ], Response::HTTP_OK);

    }

}