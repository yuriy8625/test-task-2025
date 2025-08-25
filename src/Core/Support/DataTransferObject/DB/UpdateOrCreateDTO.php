<?php

namespace Core\Support\DataTransferObject\DB;

use Core\Support\DataTransferObject\DTO;

class UpdateOrCreateDTO extends DTO
{
    const UPDATED = 'updated';
    const CREATED = 'created';

    const NO_ACTION = 'no_action';

    const ACTIVE_ACTIONS = [
        self::UPDATED,
        self::CREATED,
    ];

    public function __construct(
        public int $id,
        public string $action,
    )
    {
    }
}