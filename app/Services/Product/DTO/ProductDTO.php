<?php

namespace App\Services\Product\DTO;

use Core\Support\DataTransferObject\DTO;

class ProductDTO extends DTO
{
    public function __construct(
        readonly string $title,
        readonly float $price,
        readonly array|null $properties = null,
    )
    {

    }

    public static function fromArray(array $data): DTO
    {
        return new self(
            $data['title'],
            $data['price'],
            $data['properties'] ?? [],
        );
    }
}