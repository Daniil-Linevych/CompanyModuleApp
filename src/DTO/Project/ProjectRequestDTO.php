<?php

namespace App\DTO\Project;

use App\Enum\ProjectStatus;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $title;

    #[Assert\Length(max: 5000)]
    public ?string $description = null;

    #[Assert\Date(message: 'startDate must be a valid date string (Y-m-d).')]
    public ?string $startDate = null;

    #[Assert\NotNull]
    #[Assert\Choice(callback: [ProjectStatus::class, 'values'])]
    public string $status;

    #[Assert\Type('integer')]
    public ?int $companyId = null;

    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    public array $employeeIds = [];
}
