<?php

namespace Onboarding\Exercicio3\ValueObjects;

class Letter
{
    /**
     * @param string $letter
     * @param int $letterNumber
     * @param bool $isAnHappyNumber
     * @param bool $isAnPrimeNumber
     * @param bool $isMultipleOfThreeOrFive
     */
    public function __construct(
        public readonly string $letter,
        public readonly int  $letterNumber,
        public readonly bool $isAnHappyNumber,
        public readonly bool $isAnPrimeNumber,
        public readonly bool $isMultipleOfThreeOrFive,
    )
    {}
}
