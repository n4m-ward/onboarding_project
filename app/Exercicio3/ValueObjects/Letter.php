<?php

namespace Onboarding\Exercicio3\ValueObjects;

class Letter
{
    public function __construct(
        public readonly string $letter,
        public readonly int    $letterNumber,
        public readonly bool   $isAnHappyNumber,
        public readonly bool   $isAnPrimeNumber,
        public readonly bool   $isMultipleOfThreeOrFive,
    )
    {
    }
}
