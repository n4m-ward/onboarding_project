<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Dto\CarrinhoDto;

class CarrinhoDb extends BaseDb
{
    public string $table = 'carrinho';
    public string $dtoClass = CarrinhoDto::class;
}