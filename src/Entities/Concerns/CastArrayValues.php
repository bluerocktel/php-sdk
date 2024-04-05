<?php

namespace BlueRockTEL\SDK\Entities\Concerns;

use Carbon\Carbon;
use BlueRockTEL\SDK\Exceptions\InvalidCastException;

trait CastArrayValues
{
    /**
     * The attributes that should be cast when created from an array.
     *
     * @var array
     */
    protected static $arrayCast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getCastAttributes(): array
    {
        return static::$arrayCast ?? [];
    }

    public static function castArrayValues(array &$values, array $cast)
    {
        foreach ($values as $key => $value) {
            if (is_null($value) || !array_key_exists($key, $cast)) {
                continue;
            }

            $values[$key] = match ($cast[$key]) {
                'null' => null,
                'int', 'integer' => (int) $value,
                'float' => (float) $value,
                'bool', 'boolean' => (bool) $value,
                'string' => (string) $value,
                'array' => (array) $value,
                'object' => (object) $value,
                'date', 'datetime', 'carbon' => is_a($value, Carbon::class) ? $value : Carbon::parse($value),
                default => throw new InvalidCastException(
                    'Invalid cast type `' . $cast[$key] . '` for key `' . $key . '`.'
                ),
            };
        }
    }
}