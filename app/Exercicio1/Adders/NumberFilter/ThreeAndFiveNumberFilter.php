<?php

namespace Onboarding\Exercicio1\Adders\NumberFilter;

class ThreeAndFiveNumberFilter extends BaseNumberFilter
{
    /**
     * @param array<int> $arrayToFilter
     * @return  array<int>
     */
    public function filterNumbers(array $arrayToFilter): array
    {
        return array_filter($arrayToFilter, function (int $arrayNumber) {
            $numberIsMultipleOfThree = $this->numberIsMultiple(number: $arrayNumber, multiple: 3);
            $numberIsMultipleOfFive = $this->numberIsMultiple(number: $arrayNumber, multiple: 5);

            return $numberIsMultipleOfThree
                && $numberIsMultipleOfFive;
        });
    }
}
