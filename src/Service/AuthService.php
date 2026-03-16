<?php

namespace App\Service;

use App\DTO\User\RegisterUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function register(RegisterUserDTO $dto): User
    {
        if ($this->userRepository->findOneBy(['email' => $dto->email])) {
            throw new ConflictHttpException('Email already registered');
        }

        $user = new User();
        $this->hydrate($user, $dto);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    private function hydrate(User $user, RegisterUserDTO $dto)
    {
        $user->setEmail($dto->email);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $dto->password);
        $user->setPassword($hashedPassword);
    }
}
