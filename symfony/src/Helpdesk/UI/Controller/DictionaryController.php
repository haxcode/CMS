<?php

namespace App\Helpdesk\UI\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Helpdesk\Domain\ValueObject\Importance;

class DictionaryController extends AbstractController {

    /**
     * @Route(path="/api/helpdesk/dic/importance", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getImportanceLevel(Request $request): JsonResponse {

        return $this->json(['data' => Importance::getTypes()]);
    }

}