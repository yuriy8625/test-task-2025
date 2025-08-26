<?php

namespace Core\Support\DataTransferObject\DB;

use Core\Support\DataTransferObject\DTO;

class PaginationDTO extends DTO
{
    public function __construct(
        readonly array $items = [],
        readonly int $total = 0,
        readonly int $page = 1,
        readonly int $limit = 10,
    )
    {

    }

    public static function fromArray(array $data): DTO
    {
        return new self(
            $data['items'] ?? [],
            $data['total'] ?? 0,
            $data['page'] ?? 1,
            $data['limit'] ?? 10,
        );
    }
}