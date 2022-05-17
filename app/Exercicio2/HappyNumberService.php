<?php

namespace Onboarding\Exercicio2;

class HappyNumberService
{
    public function isAnHappyNumber(int $number, array $previousNumber = []): bool
    {
        if ($number == 0) {
            return true;
        }

        if (in_array($number, $previousNumber)) {
            return false;
        }
    }

    private function squareNumber(int $number): int
    {

    }
}