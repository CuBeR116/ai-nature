<?php

declare(strict_types = 1);

namespace App\Mutator;

class ArrayMutator
{
    public static function getAllArrayValues(array $values, array $skipKeys = []): array
    {
        $result = [];
        array_walk_recursive($values, function ($value, $key) use ($skipKeys, &$result) {
            if (in_array($key, $skipKeys)) {
                $result[] = $value;
            }
        });

        return $result;
    }
}
