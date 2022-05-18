<?php

declare(strict_types=1);

namespace Onboarding\Exercicio1\Adders;

use Exception;
use Onboarding\Exercicio1\Adders\NumberFilter\ThreeAndFiveNumberFilter;
use Onboarding\Exercicio1\Adders\NumberFilter\ThreeOrFiveAndSevenNumberFilter;
use Onboarding\Exercicio1\Adders\NumberFilter\ThreeOrFiveNumberFilter;

final class MultipleNumbersAdder
{
    private const NUMBER_FILTER = [
        'multipleOfThreeOrFive' => ThreeOrFiveNumberFilter::class,
        'multipleOfThreeAndFive' => ThreeAndFiveNumberFilter::class,
        'multipleOfThreeOrFiveAndSeven' => ThreeOrFiveAndSevenNumberFilter::class,
    ];

    public function __construct(
        private readonly int $initialValueInArray,
        private readonly int $finalValueInArray,
    ) {
    }

    /**
     * @return  array<int>
     *
     * @throws Exception
     */
    public function getSumOfMultiples(): array
    {
        $arrayWithAllSum = [];
        $filledArray = $this->getArrayInRange();

        foreach (
            self::NUMBER_FILTER
            as $numberSumMethod => $numberFilterClass
        ) {
            $numberFilterInstance = new $numberFilterClass();
            $arrayWithFilteredNumbers = $numberFilterInstance
                ->filterNumbers($filledArray);
            $sumOfAllNumbers = array_sum($arrayWithFilteredNumbers);
            $arrayWithAllSum[$numberSumMethod] = $sumOfAllNumbers;
        }

        return $arrayWithAllSum;
    }

    /**
     * @throws Exception
     *
     * @return  array<int>
     */
    private function getArrayInRange(): array
    {
        return range(
            start: $this->initialValueInArray,
            end: $this->finalValueInArray - 1
        );
    }
}
