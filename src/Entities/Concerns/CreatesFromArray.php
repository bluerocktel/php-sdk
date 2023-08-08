<?php

namespace BlueRockTEL\SDK\Entities\Concerns;

use ReflectionClass;
use Illuminate\Support\Collection;

trait CreatesFromArray
{
    public static function createFromArray(array $data): static
    {
        $arguments = new Collection();
        $className = static::class;

        $reflector = new ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        if ($constructor) {
            $parameters = $constructor->getParameters();
            foreach ($parameters as $parameter) {
                $arguments->push($parameter->getName());
            }
        }

        return new $className(
            ...array_intersect_key($data, $arguments->flip()->toArray())
        );
    }
}