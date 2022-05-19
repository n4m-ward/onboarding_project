<?php

namespace Onboarding\Exercicio4\Interfaces;

use Tightenco\Collect\Support\Collection;

interface DbInterface
{
    public function getAll(): Collection;
    public function insert(Dto $tableDto): Dto;
    public function where(string $column, string $symbol, string|int|bool $value): static;
    public function delete(): void;
    public function update(Dto $tableDto): Dto;
}
