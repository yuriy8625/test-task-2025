<?php

namespace App\Services\Product\DTO;

use Core\Support\DataTransferObject\DTO;

class ProductFilterDTO extends DTO
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_SORT_FIELD = 'title';
    const DEFAULT_SORT_DIRECTION = 'asc';

    const SORT_FIELDS = ['title', 'price'];

    public function __construct(
        readonly string $sort,
        readonly string $direction,
        readonly int    $page,
        readonly int    $limit,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        $sort = !empty($data['sort']) && in_array($data['sort'], self::SORT_FIELDS)
            ? $data['sort']
            : self::DEFAULT_SORT_FIELD;

        $direction = !empty($data['direction']) && $data['direction'] === 'desc'
            ? 'desc'
            : self::DEFAULT_SORT_DIRECTION;

        return new self(
            $sort,
            $direction,
            (int)$data['page'] ?? 1,
            $data['limit'] ?? self::DEFAULT_LIMIT
        );
    }
}