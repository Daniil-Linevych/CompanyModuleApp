<?php

namespace App\Service;

use App\DTO\PaginatedResult;
use App\DTO\SearchRequestDTO;
use App\Service\Query\QueryFilterApplier;
use App\Service\Query\QuerySorter;
use App\Service\Query\QueryPaginator;
use Doctrine\ORM\QueryBuilder;

class RetrieveDataService
{
    public function __construct(
        private QueryFilterApplier $filterApplier,
        private QuerySorter $sorter,
        private QueryPaginator $paginator,
    ) {
    }

    public function execute(QueryBuilder $qb, SearchRequestDTO $search): PaginatedResult
    {
        $this->filterApplier->applyFilters($qb, $search);

        $this->sorter->applySorting($qb, $search);

        return $this->paginator->paginate($qb, $search);
    }
}
