<?php

namespace Onboarding\Exercicio3\ValueObjects;

class Word
{
    /**
     * @param array<Letter> $letters
     */
    public function __construct(
        public readonly string $word,
        public readonly int $totalWordValue,
        public readonly array  $letters,
    ) {}
}
