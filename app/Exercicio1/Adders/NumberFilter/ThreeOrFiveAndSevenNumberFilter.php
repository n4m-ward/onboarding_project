<?php

namespace Onboarding\Exercicio1\Adders\NumberFilter;

class ThreeOrFiveAndSevenNumberFilter extends BaseNumberFilter
{
    public function filterNumbers(array $arrayToFilter): array
    {
        return array_filter($arrayToFilter, function (int $arrayNumber) {
            $numberIsMultipleOfThree = $this->numberIsMultiple(number: $arrayNumber, multiple: 3);
            $numberIsMultipleOfFive = $this->numberIsMultiple(number: $arrayNumber, multiple: 5);
            $numberIsMultipleOfSeven = $this->numberIsMultiple(number: $arrayNumber, multiple: 7);

            return ($numberIsMultipleOfThree || $numberIsMultipleOfFive)
                && $numberIsMultipleOfSeven;
        });
    }
}