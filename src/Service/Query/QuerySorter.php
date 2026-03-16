<?php

namespace App\Service\Query;

use App\DTO\SearchRequestDTO;
use Doctrine\ORM\QueryBuilder;

class QuerySorter
{
    public function applySorting(QueryBuilder $qb, SearchRequestDTO $search): void
    {
        if (!$search->sort) {
            return;
        }

        $alias = $qb->getRootAliases()[0];
        $sortField = $alias.'.'.$search->sort;

        $direction = 'DESC' === strtoupper($search->direction) ? 'DESC' : 'ASC';
        $qb->orderBy($sortField, $direction);
    }
}
