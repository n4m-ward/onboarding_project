<?php

declare(strict_types=1);

namespace Onboarding\Exercicio3\ValueObjects;

final class Word
{
    /**
     * @param array<Letter> $letters
     */
    public function __construct(
        public readonly string $word,
        public readonly int $totalWordValue,
        public readonly array $letters,
    ) {
    }
}
