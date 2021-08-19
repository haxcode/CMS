<?php

namespace App\Planing\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Planing\Domain\ValueObject\Status;

class DictionaryController extends AbstractController {

    /**
     * @Route(path="/api/plan/dic/statuses", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getStatuses(Request $request): JsonResponse {

        return $this->json(['data' => Status::getTypes()]);
    }

}