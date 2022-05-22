<?php

namespace Onboarding\Exercicio4\Interfaces;

use Onboarding\Exercicio4\Dto\BaseTableDto;
use Tightenco\Collect\Support\Collection;

interface DbInterface
{
    public static function getAll(): Collection;
    public static function insert(BaseTableDto $tableDto): BaseTableDto;
    public static function query(): static;
    public function where(string $column, string $symbol, string|int|bool $value): static;
    public function delete(): void;
    public function update(BaseTableDto $tableDto): BaseTableDto;
}
