<?php

namespace Onboarding\Exercicio1\Adders\NumberFilter;

abstract class BaseNumberFilter
{
    /**
     * @param array<int> $arrayToFilter
     * @return  array<int>
     */
    abstract public function filterNumbers(array $arrayToFilter): array;

    public function numberIsMultiple(int $number, int $multiple): bool
    {
        return $number % $multiple == 0;
    }
}
