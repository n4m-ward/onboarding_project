<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Database\Factories\ProdutoFactory;
use Onboarding\Exercicio4\Dto\ProductDto;

class ProductDb extends BaseDb
{
    public string $table = 'product';
    public string $dtoClass = ProductDto::class;
    public string $factoryClass = ProdutoFactory::class;
}
