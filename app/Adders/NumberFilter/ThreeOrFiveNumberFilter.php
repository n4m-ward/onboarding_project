<?php

namespace Onboarding\Adders\NumberFilter;

class ThreeOrFiveNumberFilter extends BaseNumberFilter
{
    public function filterNumbers(array $arrayToFilter): array
    {
        return array_filter($arrayToFilter, function ($arrayNumber) {
            $numberIsMultipleOfThree = $this->numberIsMultiple(number: $arrayNumber, multiple: 3);
            $numberIsMultipleOfFive = $this->numberIsMultiple(number: $arrayNumber, multiple: 5);

            return $numberIsMultipleOfThree
                || $numberIsMultipleOfFive;
        });
    }
}
