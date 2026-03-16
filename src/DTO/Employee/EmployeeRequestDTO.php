<?php

namespace App\DTO\Employee;

use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\EmployeePosition;

final class EmployeeRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $firstName;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotNull]
    #[Assert\Choice(callback: [EmployeePosition::class, 'values'])]
    public string $position;

    #[Assert\Type('integer')]
    public ?int $companyId = null;

    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    public array $projectIds = [];
}
