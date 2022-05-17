<?php

namespace Onboarding\Exercicio2;

class HappyNumberService
{
    /**
     * @param int $number
     * @param array<int> $previousNumbers
     * @return bool
     */
    public function isAnHappyNumber(int $number, array $previousNumbers = []): bool
    {
        if ($number == 1) {
            return true;
        }

        if (in_array($number, $previousNumbers)) {
            return false;
        }
        $previousNumbers[] = $number;
        $numberAfterSquareAndSum = $this->squareAndSumEachDigitOfNumber($number);

        return $this->isAnHappyNumber($numberAfterSquareAndSum, $previousNumbers);
    }

    /**
     * @param int $number
     * @return int
     */
    private function squareAndSumEachDigitOfNumber(int $number): int
    {
        $numberToReturn = 0;
        $splittedNumberArray = str_split("$number");

        foreach ($splittedNumberArray as $number) {
            $numberToReturn += $this->squareNumber((int)$number);
        }

        return $numberToReturn;
    }

    /**
     * @param int $number
     * @return int
     */
    private function squareNumber(int $number): int
    {
        return $number * $number;
    }
}
