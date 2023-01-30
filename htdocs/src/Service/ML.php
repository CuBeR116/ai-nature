<?php

declare(strict_types = 1);

namespace App\Service;

use Exception;
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

    /**
     * Происходит обучение нейронки
     *
     * @param int $tries
     *
     * @throws Exception
     * @return void
     */
    public function train(int $tries = 100): void
    {
        for ($i = 1; $i <= $tries; $i++) {
            $values = MLEnum::EMPTY_DATA;

            //Случайным образом распределяем животных
            $sum = 0;
            while ($sum <= 6) {
                foreach ($values as &$value) {
                    if ($value[2] === 1) {
                        continue;
                    }
                    $rand = random_int(0, 1);
                    $value[2] = $rand;
                    $sum += $rand;

                    if ($sum === 6) {
                        break 2;
                    }
                }
            }
            unset($value);

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

            $values = ArrayMutator::getAllArrayValues($group, [2]);
            $this->classifier->train([$values], [$result]);
        }
    }

    public function getClassifier(): Estimator
    {
        return $this->classifier;
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
