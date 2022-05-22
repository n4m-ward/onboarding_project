<?php

namespace Onboarding\Exercicio4\Dto;

class CarrinhoDto extends BaseTableDto
{
    public int $userId;

    /**
     * @var array<ProdutoQuantityDto>
     */
    public array $wishList = [];
}
