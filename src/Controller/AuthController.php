<?php

namespace App\Controller;

use App\DTO\RegisterUserDTO;
use App\Services\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class AuthController extends AbstractController
{
    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] RegisterUserDTO $dto,
        AuthService $authService,
    ): JsonResponse {

        $user = $authService->register($dto->email, $dto->password);

        return $this->json(['message' => 'User created', 'user' => $user], Response::HTTP_CREATED, [], ['groups' => ['user:read']]);
    }
}
