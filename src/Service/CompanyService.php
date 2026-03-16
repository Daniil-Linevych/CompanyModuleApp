<?php

namespace App\Service;

use App\Entity\Company;
use App\DTO\Company\CompanyRequestDTO;
use App\Repository\CompanyRepository;
use App\DTO\PaginatedResult;
use App\DTO\SearchRequestDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyService
{
    public function __construct(
        private CompanyRepository $repository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function getCompanies(SearchRequestDTO $search): PaginatedResult
    {
        return $this->repository->retrieveData($search);
    }

    public function getCompany(int $id): Company
    {
        return $this->findOrFail($id);
    }

    public function createCompany(CompanyRequestDTO $dto): Company
    {

        $company = new Company();
        $this->hydrate($company, $dto);

        $this->em->persist($company);
        $this->em->flush();


        return $company;
    }

    public function updateCompany(int $id, CompanyRequestDTO $dto): Company
    {
        $company = $this->findOrFail($id);
        $this->hydrate($company, $dto);

        $this->em->flush();

        return $company;
    }

    public function deleteCompany(int $id): void
    {
        $company = $this->findOrFail($id);

        $this->em->remove($company);
        $this->em->flush();
    }

    private function findOrFail(int $id): Company
    {
        $company = $this->repository->find($id);

        if (!$company) {
            throw new NotFoundHttpException('Company not found.');
        }

        return $company;
    }

    private function hydrate(Company $company, CompanyRequestDTO $dto): void
    {
        $company->setName($dto->name);
        $company->setIndustry($dto->industry);
        $company->setFoundedYear($dto->foundedYear);
    }
}
