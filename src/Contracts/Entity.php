<?php

namespace BlueRockTEL\SDK\Contracts;

use Illuminate\Support\Collection;

interface Entity
{
    public static function fromArray(array $data): static;
    public function toArray(bool $filter = false): array;
    public function toCollection(bool $filter = false): Collection;
}