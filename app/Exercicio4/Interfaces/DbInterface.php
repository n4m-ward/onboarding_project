<?php

namespace Onboarding\Exercicio4\Interfaces;

use Onboarding\Exercicio4\Dto\BaseTableDto;
use Tightenco\Collect\Support\Collection;

interface DbInterface
{
    public function getAll(): Collection;
    public function insert(BaseTableDto $tableDto): BaseTableDto;
    public function where(string $column, string $symbol, string|int|bool $value): static;
    public function delete(): void;
    public function update(BaseTableDto $tableDto): BaseTableDto;
}
