<?php

namespace Onboarding\Exercicio4\Dto;

class ProdutoQuantityDto extends BaseDto
{
    public ?ProdutoDto $product = null;
    public int $quantity = 1;
}
