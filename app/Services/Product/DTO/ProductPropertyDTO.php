<?php

namespace App\Services\Product\DTO;

use Core\Support\DataTransferObject\DTO;

class ProductPropertyDTO extends DTO
{
    public function __construct(
        readonly int    $product_id,
        readonly string $name,
        readonly mixed  $value,
    )
    {

    }

    public static function fromArray(array $data): DTO
    {
        return new self(
            $data['product_id'],
            $data['name'],
            $data['value'],
        );
    }
}