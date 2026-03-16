<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PaginatedResult;
use App\DTO\Project\ProjectRequestDTO;
use App\DTO\SearchRequestDTO;
use App\Entity\Company;
use App\Entity\Employee;
use App\Entity\Project;
use App\Enum\ProjectStatus;
use App\Repository\EmployeeRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ProjectService
{
    public function __construct(
        private readonly ProjectRepository $repository,
        private readonly EmployeeRepository $employeeRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function getProjects(SearchRequestDTO $search): PaginatedResult
    {
        return $this->repository->retrieveData($search);
    }

    public function getProject(int $id): Project
    {
        return $this->findOrFail($id);
    }

    public function createProject(ProjectRequestDTO $dto): Project
    {
        $project = new Project();
        $this->hydrate($project, $dto);

        $this->em->persist($project);
        $this->em->flush();

        return $project;
    }

    public function updateProject(int $id, ProjectRequestDTO $dto): Project
    {
        $project = $this->findOrFail($id);
        $this->hydrate($project, $dto);

        $this->em->flush();

        return $project;
    }

    public function deleteProject(int $id): void
    {
        $project = $this->findOrFail($id);

        $this->em->remove($project);
        $this->em->flush();
    }

    private function findOrFail(int $id): Project
    {
        $project = $this->repository->find($id);

        if (!$project) {
            throw new NotFoundHttpException("Project #{$id} not found.");
        }

        return $project;
    }

    private function hydrate(Project $project, ProjectRequestDTO $dto): void
    {
        $project->setTitle($dto->title);
        $project->setDescription($dto->description);
        $project->setStatus(ProjectStatus::from($dto->status));

        $project->setStartDate(
            null !== $dto->startDate
                ? new \DateTime($dto->startDate)
                : null
        );

        if (null !== $dto->companyId) {
            $company = $this->em->getReference(Company::class, $dto->companyId);
            $project->setCompany($company);
        } else {
            $project->setCompany(null);
        }

        $this->syncEmployees($project, $dto->employeeIds);
    }

    private function syncEmployees(Project $project, array $employeeIds): void
    {
        foreach ($project->getEmployees()->toArray() as $employee) {
            $project->removeEmployee($employee);
        }

        if (empty($employeeIds)) {
            return;
        }

        $employees = $this->employeeRepository->findBy(['id' => $employeeIds]);

        foreach ($employees as $employee) {
            if ($employee instanceof Employee) {
                $project->addEmployee($employee);
            }
        }
    }
}
