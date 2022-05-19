<?php

namespace Onboarding\Exercicio4\Dto;

class WhereDto extends BaseDto
{
    public string $column;
    public string $symbol;
    public string|int|bool $value;
}