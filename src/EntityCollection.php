<?php

namespace BlueRockTEL\SDK;

use Illuminate\Support\Collection;
use Saloon\Http\Response;

class EntityCollection extends Collection
{
    public static function fromResponse(Response $response, string $dtoClass, $pathKey = null): static
    {
        $elements = $response
            ->collect($pathKey)
            ->map(fn (array $el) => $dtoClass::fromArray($el));

        return new static($elements);
    }

    public static function fromArray(array $response, string $dtoClass): static
    {
        $elements = collect($response)
            ->map(fn (array $el) => $dtoClass::fromArray($el));

        return new static($elements);
    }
}
