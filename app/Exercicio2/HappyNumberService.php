<?php

declare(strict_types=1);

namespace Onboarding\Exercicio2;

final class HappyNumberService
{
    /**
     * @param array<int> $previousNumbers
     */
    public function isAnHappyNumber(
        int $number,
        array $previousNumbers = []
    ): bool {
        if ($number === 1) {
            return true;
        }

        if (in_array($number, $previousNumbers)) {
            return false;
        }
        $previousNumbers[] = $number;
        $numberAfterSquareAndSum = $this
            ->squareAndSumEachDigitOfNumber($number);

        return $this->isAnHappyNumber(
            $numberAfterSquareAndSum,
            $previousNumbers
        );
    }

    private function squareAndSumEachDigitOfNumber(int $number): int
    {
        $numberToReturn = 0;
        $splittedNumberArray = str_split("{$number}");

        foreach ($splittedNumberArray as $number) {
            $numberToReturn += $this->squareNumber((int) $number);
        }

        return $numberToReturn;
    }

    private function squareNumber(int $number): int
    {
        return $number * $number;
    }
}
