<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\SearchRequestDTO;
use App\Service\EmployeeService;
use App\DTO\Employee\EmployeeRequestDTO;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route('/employees')]
final class EmployeeController extends AbstractController
{
    public function __construct(private EmployeeService $service)
    {
    }

    #[Route('', name: 'api_employees', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $req = SearchRequestDTO::fromRequest($request);

        $result = $this->service->getEmployees($req);

        return $this->json([
            'data' => $result->items,
            'meta' => [
                'page' => $result->page,
                'limit' => $result->limit,
                'total' => $result->total,
            ],
        ], Response::HTTP_OK, [], ['groups' => ['employee:list']]);
    }

    #[Route('/{id}', name: 'api_employee', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $employee = $this->service->getEmployee($id);

        return $this->json([
            'data' => $employee,
        ], Response::HTTP_OK, [], ['groups' => ['employee:list', 'employee:detail']]);
    }

    #[Route('', name: 'api_employee_create', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(
        #[MapRequestPayload] EmployeeRequestDTO $dto,
    ): JsonResponse {
        $employee = $this->service->createEmployee($dto);

        return $this->json(
            ['data' => $employee],
            Response::HTTP_CREATED,
            [],
            ['groups' => ['employee:list', 'employee:detail']],
        );
    }

    #[Route('/{id}', name: 'api_employee_update', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function update(
        int $id,
        #[MapRequestPayload] EmployeeRequestDTO $dto,
    ): JsonResponse {
        $company = $this->service->updateEmployee($id, $dto);

        return $this->json(
            ['data' => $company],
            Response::HTTP_OK,
            [],
            ['groups' => ['employee:list', 'employee:detail']],
        );
    }

    #[Route('/{id}', name: 'api_employee_delete', methods: ['DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteEmployee($id);

        return $this->json(['Message' => 'Deleted successfully!'], Response::HTTP_NO_CONTENT);
    }
}
