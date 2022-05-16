<?php

namespace Onboarding\Adders;

class MultipleNumbersAdder
{
    public function getSumOfMultiplesInRange($min, $max): array
    {
        $arrayInRangeTo1000 = range($min, $max -1);
        $result = array_filter($arrayInRangeTo1000, function($number) {
            $numberIsMultipleOfThree = $this->numberIsMultiple(number: $number, multiple: 3);
            $numberIsMultipleOfFive = $this->numberIsMultiple(number: $number, multiple: 5);

            return $numberIsMultipleOfThree
                || $numberIsMultipleOfFive;
        });

        return ['multipleOfThreeAndFive' => array_sum($result)];
    }

    private function numberIsMultiple(int $number, int $multiple): bool
    {
        return $number % $multiple == 0;
    }
}
