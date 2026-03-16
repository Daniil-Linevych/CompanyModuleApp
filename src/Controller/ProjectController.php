<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Project\ProjectRequestDTO;
use App\DTO\SearchRequestDTO;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/projects')]
final class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectService $service,
    ) {
    }

    #[Route('', name: 'api_projects', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $req    = SearchRequestDTO::fromRequest($request);
        $result = $this->service->getProjects($req);

        return $this->json([
            'data' => $result->items,
            'meta' => [
                'page'  => $result->page,
                'limit' => $result->limit,
                'total' => $result->total,
            ],
        ], Response::HTTP_OK, [], ['groups' => ['project:list']]);
    }

    #[Route('/{id}', name: 'api_project_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $project = $this->service->getProject($id);

        return $this->json(
            ['data' => $project],
            Response::HTTP_OK,
            [],
            ['groups' => ['project:list', 'project:detail']],
        );
    }

    #[Route('', name: 'api_project_create', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(
        #[MapRequestPayload] ProjectRequestDTO $dto,
    ): JsonResponse {
        $project = $this->service->createProject($dto);

        return $this->json(
            ['data' => $project],
            Response::HTTP_CREATED,
            [],
            ['groups' => ['project:list', 'project:detail']],
        );
    }

    #[Route('/{id}', name: 'api_project_update', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function update(
        int $id,
        #[MapRequestPayload] ProjectRequestDTO $dto,
    ): JsonResponse {
        $project = $this->service->updateProject($id, $dto);

        return $this->json(
            ['data' => $project],
            Response::HTTP_OK,
            [],
            ['groups' => ['project:list', 'project:detail']],
        );
    }

    #[Route('/{id}', name: 'api_project_delete', methods: ['DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteProject($id);

        return $this->json(['Message' => 'Deleted successfully!'], Response::HTTP_NO_CONTENT);
    }
}
