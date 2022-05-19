<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Dto\ProdutoDto;

class ProdutoDb extends BaseDb
{
    public string $table = 'produto';
    public string $dtoClass = ProdutoDto::class;
}