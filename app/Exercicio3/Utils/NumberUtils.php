<?php

declare(strict_types=1);

namespace Onboarding\Exercicio3\Utils;

use Onboarding\Exercicio1\Adders\NumberFilter\ThreeOrFiveNumberFilter;

final class NumberUtils
{
    public function __construct(
        private readonly ThreeOrFiveNumberFilter $threeOrFiveNumberFilter
    ) {
    }

    public function isAnPrimeNumber(int $number): bool
    {
        for ($i = 2; $i < $number; $i++) {
            $itsAnPrimeNumber = $this->threeOrFiveNumberFilter
                ->numberIsMultiple(number: $number, multiple: $i);

            if ($itsAnPrimeNumber) {
                return false;
            }
        }

        return true;
    }

    public function numberIsMultipleOfThreeOrFive(int $number): bool
    {
        $numberIsMultipleOfThree = $this->threeOrFiveNumberFilter
            ->numberIsMultiple(number: $number, multiple: 3);
        $numberIsMultipleOfFive = $this->threeOrFiveNumberFilter
            ->numberIsMultiple(number: $number, multiple: 5);

        return $numberIsMultipleOfThree
        || $numberIsMultipleOfFive;
    }
}
