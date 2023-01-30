<?php

declare(strict_types = 1);

namespace App\Enum;

class ML
{
    /**
     * Все площадки разделены следующим способом:
     * Первое число обозначает зону наблюдения, где есть 2 места.
     *
     * Второе число обозначает тип прилигающей зоны:
     * 1 - Океан
     * 2 - Тропический лес
     *
     * Третье число означает, как распредилили людей:
     * 1 - Если в зоне нет животных, то, один посетитель в зоне
     * 2 - Если в зоне 2 животных, то, только 1 ученый
     * 3 - Если в зоне одно животное, то, 1 ученый и/или 1 посетитель
     */
    public const EMPTY_DATA = [
        [1, 1, 0],
        [1, 1, 0],
        [2, 2, 0],
        [2, 2, 0],
        [3, 2, 0],
        [3, 2, 0],
        [4, 2, 0],
        [4, 2, 0],
        [5, 1, 0],
        [5, 1, 0],
        [6, 1, 0],
        [6, 1, 0],
    ];

    public const SAVE_DIR = '/ai/model';
}
