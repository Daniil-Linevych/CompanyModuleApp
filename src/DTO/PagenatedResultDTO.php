<?php

namespace App\DTO;

class PaginatedResult
{
    public function __construct(
        public array $items,
        public int $total,
        public int $page,
        public int $limit,
    ) {
    }
}
/*
<?php

namespace App\DTO;

class PaginatedResult
{
    public array $items,
    public int $total,
     public int $page,
    public int $limit

}*/
