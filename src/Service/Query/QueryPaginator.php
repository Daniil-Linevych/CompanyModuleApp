<?php

namespace App\Service\Query;

use App\DTO\PaginatedResult;
use App\DTO\SearchRequestDTO;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QueryPaginator
{
    public function paginate(QueryBuilder $qb, SearchRequestDTO $search): PaginatedResult
    {
        $query = $qb->getQuery()
            ->setFirstResult(($search->page - 1) * $search->limit)
            ->setMaxResults($search->limit);

        $paginator = new Paginator($query, true);

        return new PaginatedResult(
            iterator_to_array($paginator),
            count($paginator),
            $search->page,
            $search->limit
        );
    }
}
