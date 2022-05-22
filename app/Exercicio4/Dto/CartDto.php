<?php

namespace Onboarding\Exercicio4\Dto;

class CartDto extends BaseTableDto
{
    public int $userId;

    /**
     * @var array<ProdutoQuantityDto>
     */
    public array $wishList = [];
}
