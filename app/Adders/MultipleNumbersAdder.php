<?php

namespace Onboarding\Adders;

use Exception;
use Onboarding\Adders\NumberFilter\ThreeAndFiveNumberFilter;
use Onboarding\Adders\NumberFilter\ThreeOrFiveAndSevenNumberFilter;
use Onboarding\Adders\NumberFilter\ThreeOrFiveNumberFilter;

class MultipleNumbersAdder
{
    private int $initialValueInArray;
    private int $finalValueInArray;

    private const NUMBER_FILTER = [
        'multipleOfThreeOrFive' => ThreeOrFiveNumberFilter::class,
        'multipleOfThreeAndFive' => ThreeAndFiveNumberFilter::class,
        'multipleOfThreeOrFiveAndSeven' => ThreeOrFiveAndSevenNumberFilter::class,
    ];

    public function setRange(int $initialValue, int $finalValue): MultipleNumbersAdder
    {
        $this->initialValueInArray = $initialValue;
        $this->finalValueInArray = $finalValue -1;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function getSumOfMultiples(): array
    {
        $arrayWithAllSum = [];
        $filledArray = $this->getArrayInRange();

        foreach (self::NUMBER_FILTER as $numberSumMethod => $numberFilterClass) {
            $numberFilterInstance = new $numberFilterClass();
            $arrayWithFilteredNumbers = $numberFilterInstance->filterNumbers($filledArray);
            $arrayWithAllSum[$numberSumMethod] = array_sum($arrayWithFilteredNumbers);
        }

        return $arrayWithAllSum;
    }

    /**
     * @throws Exception
     */
    private function getArrayInRange(): array
    {
        $minimumOrMaxValueIsNull = in_array(
            null,
            [$this->initialValueInArray, $this->finalValueInArray]
        );

        if ($minimumOrMaxValueIsNull) {
            throw new Exception('Por favor use o metodo setRange() antes do metodo getSumOfMultiples()');
        }

        return range(start: $this->initialValueInArray, end: $this->finalValueInArray);
    }
}
