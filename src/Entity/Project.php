<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Enum\ProjectStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: 'projects')]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['project:list', 'company:detail', 'employee:detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['project:list', 'company:detail', 'employee:detail'])]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['project:list'])]
    private ?string $description = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['project:list'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(enumType: ProjectStatus::class)]
    #[Groups(['project:list'])]
    private ?ProjectStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['project:detail'])]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: 'projects')]
    #[ORM\JoinTable(name: 'employee_project')]
    #[Groups(['project:detail'])]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?ProjectStatus
    {
        return $this->status;
    }

    public function setStatus(ProjectStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $date): static
    {
        $this->startDate = $date;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        $this->employees->removeElement($employee);

        return $this;
    }
}
