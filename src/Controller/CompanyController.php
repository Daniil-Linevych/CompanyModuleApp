<?php

namespace App\Controller;

use App\DTO\Company\CompanyRequestDTO;
use App\DTO\SearchRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Service\CompanyService;

#[Route('/companies')]
final class CompanyController extends AbstractController
{
    public function __construct(private CompanyService $service)
    {
    }

    #[Route('', name: 'api_companies', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $req = SearchRequestDTO::fromRequest($request);

        $result = $this->service->getCompanies($req);

        return $this->json([
            'data' => $result->items,
            'meta' => [
                'page' => $result->page,
                'limit' => $result->limit,
                'total' => $result->total,
            ],
        ], Response::HTTP_OK, [], ['groups' => ['company:list']]);
    }

    #[Route('/{id}', name: 'api_company', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $company = $this->service->getCompany($id);

        return $this->json([
            'data' => $company,
        ], Response::HTTP_OK, [], ['groups' => ['company:list', 'company:detail']]);
    }

    #[Route('', name: 'api_company_create', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(
        #[MapRequestPayload] CompanyRequestDTO $dto,
    ): JsonResponse {
        $company = $this->service->createCompany($dto);

        return $this->json(
            ['data' => $company],
            Response::HTTP_CREATED,
            [],
            ['groups' => 'company:detail'],
        );
    }

    #[Route('/{id}', name: 'api_company_update', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function update(
        int $id,
        #[MapRequestPayload] CompanyRequestDTO $dto,
    ): JsonResponse {
        $company = $this->service->updateCompany($id, $dto);

        return $this->json(
            ['data' => $company],
            Response::HTTP_OK,
            [],
            ['groups' => 'company:detail'],
        );
    }

    #[Route('/{id}', name: 'api_company_delete', methods: ['DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteCompany($id);

        return $this->json(['Message' => 'Deleted successfully!'], Response::HTTP_NO_CONTENT);
    }
}
