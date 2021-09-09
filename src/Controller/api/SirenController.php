<?php

namespace App\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SirenController extends AbstractController
{
    /**
     * @Route("/siren/{siren}", name="find_entity_by_siren")
     */
    public function find(): JsonResponse
    {
        return new JsonResponse('hello world');
    }
}