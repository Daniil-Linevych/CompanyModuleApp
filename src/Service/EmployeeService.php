<?php

namespace App\Service;

use App\Entity\Employee;
use App\Entity\Company;
use App\Entity\Project;
use App\DTO\Employee\EmployeeRequestDTO;
use App\Repository\EmployeeRepository;
use App\DTO\PaginatedResult;
use App\DTO\SearchRequestDTO;
use App\Enum\EmployeePosition;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeService
{
    public function __construct(
        private EmployeeRepository $repository,
        private ProjectRepository $projectRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function getEmployees(SearchRequestDTO $search): PaginatedResult
    {
        return $this->repository->retrieveData($search);
    }

    public function getEmployee(int $id): Employee
    {
        return $this->findOrFail($id);
    }

    public function createEmployee(EmployeeRequestDTO $dto): Employee
    {

        $company = new Employee();
        $this->hydrate($company, $dto);

        $this->em->persist($company);
        $this->em->flush();


        return $company;
    }

    public function updateEmployee(int $id, EmployeeRequestDTO $dto): Employee
    {
        $company = $this->findOrFail($id);
        $this->hydrate($company, $dto);

        $this->em->flush();

        return $company;
    }

    public function deleteEmployee(int $id): void
    {
        $company = $this->findOrFail($id);

        $this->em->remove($company);
        $this->em->flush();
    }

    private function findOrFail(int $id): Employee
    {
        $employee = $this->repository->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Employee not found.');
        }

        return $employee;
    }

    private function hydrate(Employee $employee, EmployeeRequestDTO $dto): void
    {
        $employee->setFirstName($dto->firstName);
        $employee->setLastName($dto->lastName);
        $employee->setEmail($dto->email);
        $employee->setPosition(EmployeePosition::from($dto->position));

        if (null !== $dto->companyId) {
            $company = $this->em->getReference(Company::class, $dto->companyId);
            $employee->setCompany($company);
        }

        $this->syncProjects($employee, $dto->projectIds);
    }

    private function syncProjects(Employee $employee, array $projectIds): void
    {
        $currentProjects = $employee->getProjects()->toArray();

        foreach ($currentProjects as $project) {
            if ($project instanceof Project) {
                $employee->removeProject($project);
            }
        }

        if (empty($projectIds)) {
            return;
        }


        $newProjects = $this->projectRepository->findBy(['id' => $projectIds]);

        foreach ($newProjects as $project) {
            if ($project instanceof Project) {
                $employee->addProject($project);
            }
        }
    }
}
