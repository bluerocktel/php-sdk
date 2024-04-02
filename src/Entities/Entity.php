<?php

namespace BlueRockTEL\SDK\Entities;

use Saloon\Http\Response;
use Saloon\Traits\Responses\HasResponse;
use Saloon\Contracts\DataObjects\WithResponse;
use BlueRockTEL\SDK\Entities\Concerns\CastArrayValues;
use BlueRockTEL\SDK\Contracts\Entity as EntityContract;
use BlueRockTEL\SDK\Entities\Concerns\CreatesFromArray;
use Illuminate\Support\Collection;

abstract class Entity implements EntityContract, WithResponse
{
    use HasResponse;
    use CreatesFromArray;
    use CastArrayValues;

    public static function fromResponse(Response $response): static
    {
        return static::fromArray(
            (array) $response->json()
        );
    }

    public static function fromArray(array $data): static
    {
        static::castArrayValues($data, static::getCastAttributes());

        return static::createFromArray($data);
    }

    public function toArray(bool $filter = false): array
    {
        $data = get_object_vars($this);

        return $filter
            ? array_filter($data, fn ($i) => $i !== null)
            : $data;
    }

    public function toCollection(bool $filter = false): Collection
    {
        return new Collection(
            $this->toArray($filter)
        );
    }
}