<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

class SearchRequestDTO
{
    public const MIN_PAGE = 1;
    public const MAX_LIMIT = 100;
    public const DEFAULT_LIMIT = 10;

    public int $page = self::MIN_PAGE;
    public int $limit = self::DEFAULT_LIMIT;
    public ?string $name = null;
    public ?string $title = null;
    public ?string $sort = null;
    public string $direction = 'asc';

    public static function fromRequest(Request $request): self
    {
        $dto = new self();

        $dto->page = max(self::MIN_PAGE, $request->query->getInt('page', self::MIN_PAGE));
        $dto->limit = min(self::MAX_LIMIT, $request->query->getInt('limit', self::DEFAULT_LIMIT));
        $dto->name = $request->query->get('name');
        $dto->title = $request->query->get('title');
        $dto->sort = $request->query->get('sort');
        $dto->direction = $request->query->get('direction', 'asc');

        return $dto;
    }
}
