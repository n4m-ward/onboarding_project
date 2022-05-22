<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Database\Factories\ProdutoFactory;
use Onboarding\Exercicio4\Dto\ProdutoDto;

class ProductDb extends BaseDb
{
    public string $table = 'produto';
    public string $dtoClass = ProdutoDto::class;
    public string $factoryClass = ProdutoFactory::class;
}
