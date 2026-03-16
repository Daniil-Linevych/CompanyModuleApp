<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'companies')]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company:list', 'employee:detail', 'project:detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['company:list', 'employee:detail', 'project:detail'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['company:list'])]
    private ?string $industry = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 1800, max: 2100)]
    #[Groups(['company:list'])]
    private ?int $foundedYear = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Employee::class)]
    #[Groups(['company:detail'])]
    private Collection $employees;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Project::class)]
    #[Groups(['company:detail'])]
    private Collection $projects;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIndustry(): ?string
    {
        return $this->industry;
    }

    public function setIndustry(string $industry): static
    {
        $this->industry = $industry;

        return $this;
    }

    public function getFoundedYear(): ?int
    {
        return $this->foundedYear;
    }

    public function setFoundedYear(?int $year): static
    {
        $this->foundedYear = $year;

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
            $employee->setCompany($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->employees->removeElement($employee)) {
            if ($employee->getCompany() === $this) {
                $employee->setCompany(null);
            }
        }

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
            $project->setCompany($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            if ($project->getCompany() === $this) {
                $project->setCompany(null);
            }
        }

        return $this;
    }
}
