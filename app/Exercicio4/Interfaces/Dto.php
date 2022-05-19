<?php

namespace Onboarding\Exercicio4\Interfaces;

interface Dto
{
    /**
     * @param array<int|string|bool|null> $values
     */
    public function attachValues(array $values): Dto;
}