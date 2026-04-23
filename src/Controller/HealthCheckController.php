<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/health', name: 'health', methods: ['GET'])]
    public function check(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
