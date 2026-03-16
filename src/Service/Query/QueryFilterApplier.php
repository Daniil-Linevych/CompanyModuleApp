<?php

namespace App\Service\Query;

use App\DTO\SearchRequestDTO;
use Doctrine\ORM\QueryBuilder;

class QueryFilterApplier
{
    public function applyFilters(QueryBuilder $qb, SearchRequestDTO $search): void
    {
        $alias = $qb->getRootAliases()[0];

        if ($search->name) {
            $qb->andWhere($alias.'.name LIKE :name')
                ->setParameter('name', '%'.$search->name.'%');
        }

        if ($search->title) {
            $qb->andWhere($alias.'.title LIKE :title')
                ->setParameter('title', '%'.$search->title.'%');
        }
    }
}
