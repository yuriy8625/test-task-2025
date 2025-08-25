<?php

namespace Core\Support\DataTransferObject;

abstract class DTO
{
    public static function fromArray(array $data): DTO
    {
        return new static(...$data);
    }

    public static function collection(array $data): array
    {
        $collection = [];

        foreach ($data as $item) {
            $collection[] = static::fromArray($item);
        }

        return $collection;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toJson(int $options = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT): string
    {
        return json_encode($this->toArray(), $options);
    }
}