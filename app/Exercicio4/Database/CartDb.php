<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Database\Factories\CarrinhoFactory;
use Onboarding\Exercicio4\Dto\CarrinhoDto;

class CartDb extends BaseDb
{
    public string $table = 'carrinho';
    public string $dtoClass = CarrinhoDto::class;
    public string $factoryClass = CarrinhoFactory::class;
}
