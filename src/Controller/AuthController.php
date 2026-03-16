<?php

namespace App\Controller;

use App\DTO\User\RegisterUserDTO;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] RegisterUserDTO $dto,
        AuthService $authService,
    ): JsonResponse {

        $user = $authService->register($dto);

        return $this->json(['message' => 'User created', 'user' => $user], Response::HTTP_CREATED, [], ['groups' => ['user:read']]);
    }
}
