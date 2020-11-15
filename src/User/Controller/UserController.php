<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController {

    /**
     * @Route("/user", name="user list")
     */
    public function listUsers(): Response {

        return new Response('<html><body><h1>Users List</h1></body></html>');
    }

}