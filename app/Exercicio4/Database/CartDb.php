<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Database\Factories\CarrinhoFactory;
use Onboarding\Exercicio4\Dto\CartDto;

class CartDb extends BaseDb
{
    public string $table = 'cart';
    public string $dtoClass = CartDto::class;
    public string $factoryClass = CarrinhoFactory::class;
}
