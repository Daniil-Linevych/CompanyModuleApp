<?php

namespace App\DTO\Company;

use Symfony\Component\Validator\Constraints as Assert;

final class CompanyRequestDTO
{
    #[Assert\NotBlank(message: 'Name is required.')]
    #[Assert\Length(min: 2, max: 255)]
    public string $name = '';

    #[Assert\Length(max: 255)]
    public ?string $industry = null;

    #[Assert\Range(min: 1800, max: 2100)]
    public ?int $foundedYear = null;
}
