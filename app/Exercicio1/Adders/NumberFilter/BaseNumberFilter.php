<?php

namespace Onboarding\Exercicio1\Adders\NumberFilter;

abstract class BaseNumberFilter
{
    abstract public function filterNumbers(array $arrayToFilter);

    public function numberIsMultiple(int $number, int $multiple): bool
    {
        return $number % $multiple == 0;
    }
}
