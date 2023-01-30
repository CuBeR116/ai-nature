<?php

declare(strict_types = 1);

namespace App\Service;

use Phpml\Estimator;
use App\Enum\ML as MLEnum;
use App\Mutator\ArrayMutator;

class ML
{
    private Estimator $classifier;

    public function __construct(Estimator $classifier)
    {
        $this->classifier = $classifier;
    }

    public function train(int $tries = 500): void
    {
        for ($i = 1; $i <= $tries; $i++) {
            $values = MLEnum::EMPTY_DATA;
            $values = $this->randomValues($values, 1, 3);
            $values = $this->randomValues($values, 2, 3);

            $group = [];
            foreach ($values as $value) {
                if (!isset($group[$value[0]])) {
                    $group[$value[0]] = $value;
                    $group[$value[0]][2] = 0;
                }
                $group[$value[0]][2] += $value[2];
            }

            $result = '';
            $group = array_values($group);
            foreach ($group as $key => $value) {
                $result[$key] = '0';
            }

            $keys = array_keys($this->shuffleAssoc($group));
            $visitors = ['v', 'v', 'v', 'v'];

            foreach ($keys as $key) {
                if ($group[$key][2] > -1 && $group[$key][2] < 2 && $visitors) {
                    $result[$key] = 1;
                    array_shift($visitors);
                }
            }

            $scientist = ['s', 's', 's', 's'];
            $keys = array_keys($this->shuffleAssoc($group));

            foreach ($keys as $key) {
                if ($group[$key][2] > 0 && $group[$key][2] < 3 && $scientist) {
                    if ($result[$key] === '1') {
                        $result[$key] = 3;
                    } else {
                        $result[$key] = 2;
                    }
                    array_shift($scientist);
                }
            }

            $values = ArrayMutator::getAllArrayValues($group, [0]);
            $this->classifier->train([$values], [$result]);
        }
    }

    public function getClassifier(): Estimator
    {
        return $this->classifier;
    }

    private function randomValues(array $values, int $compareValue, int $max): array
    {
        $keys = array_keys($this->shuffleAssoc($values));
        foreach ($keys as $key) {
            if ($values[$key][1] !== $compareValue) {
                continue;
            }
            while (($value = $max - rand(0, 2)) !== 0) {
                if ($value < 0 || $value === 3) {
                    continue;
                }
                $values[$key][2] = $value;
                $max -= $value;
                break;
            }
        }

        return $values;
    }

    private function shuffleAssoc($list): array
    {
        if (!is_array($list)) {
            return $list;
        }

        $keys = array_keys($list);
        shuffle($keys);
        $random = [];
        foreach ($keys as $key) {
            $random[$key] = $list[$key];
        }

        return $random;
    }
}
