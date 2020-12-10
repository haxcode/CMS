<?php

namespace App\Helpdesk\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use function Amp\Promise\all;

class CreateIssuesController extends AbstractController {

    public function __construct() {
    }

    /**
     * @Route(path="/api/helpdesk/issue",methods={"POST"})
     * @OpenApi
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse {
        
        $data = $request->request->all();


        
        return $this->json($data);
    }

    

}