<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use App\Enum\EmployeePosition;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\Table(name: 'employees')]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['employee:list', 'company:detail', 'project:detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['employee:list', 'company:detail', 'project:detail'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['employee:list', 'company:detail', 'project:detail'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['employee:list'])]
    private ?string $email = null;

    #[ORM\Column(enumType: EmployeePosition::class)]
    #[Groups(['employee:list'])]
    private ?EmployeePosition $position = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['employee:detail'])]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'employees')]
    #[Groups(['employee:detail'])]
    private Collection $projects;

    #[ORM\OneToOne(inversedBy: 'employee')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $name): static
    {
        $this->firstName = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $name): static
    {
        $this->lastName = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPosition(): ?EmployeePosition
    {
        return $this->position;
    }

    public function setPosition(EmployeePosition $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

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

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getEmployees()->contains($this)) {
                $project->removeEmployee($this);
            }
        }

        return $this;
    }
}
