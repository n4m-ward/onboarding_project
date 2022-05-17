<?php

namespace Onboarding\Exercicio2;

class HappyNumberService
{
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

    private function squareAndSumEachDigitOfNumber(int $number): int
    {
        $numberToReturn = 0;
        $splittedNumberArray = str_split($number);

        foreach ($splittedNumberArray as $number) {
            $numberToReturn += $this->squareNumber($number);
        }

        return $numberToReturn;
    }

    private function squareNumber(int $number): int
    {
        return $number * $number;
    }
}
