<?php

namespace App\Services\Product\DTO;

use Core\Support\DataTransferObject\DTO;

class ImportedProductDTO extends DTO
{
    public function __construct(
        readonly int $imported = 0,
    )
    {
    }
}