<?php

namespace BlueRockTEL\SDK\Entities\Concerns;

use ReflectionClass;
use Illuminate\Support\Collection;

trait CreatesFromArray
{
    public static function createFromArray(array $data): static
    {
        $data = static::mapKeysToParameters($data);

        return new (static::class)(
            ...array_intersect_key($data, array_flip(static::getParameterNames()))
        );
    }

    /**
     * Rename the given keys to the matching constructor parameter names, ignoring case and
     * underscores, so both `mainAddressLine1` and `main_address_line1` fill `$mainAddressLine1`.
     */
    public static function mapKeysToParameters(array $data): array
    {
        $parameters = (new Collection(static::getParameterNames()))
            ->keyBy(fn (string $name) => static::normalizeKey($name));

        $mapped = [];

        foreach ($data as $key => $value) {
            $parameter = $parameters->get(static::normalizeKey((string) $key), $key);

            // An exact match wins over a normalized one.
            if ($parameter !== $key && array_key_exists($parameter, $data)) {
                continue;
            }

            $mapped[$parameter] = $value;
        }

        return $mapped;
    }

    protected static function getParameterNames(): array
    {
        $constructor = (new ReflectionClass(static::class))->getConstructor();

        return $constructor
            ? array_map(fn ($parameter) => $parameter->getName(), $constructor->getParameters())
            : [];
    }

    protected static function normalizeKey(string $key): string
    {
        return strtolower(str_replace('_', '', $key));
    }
}
