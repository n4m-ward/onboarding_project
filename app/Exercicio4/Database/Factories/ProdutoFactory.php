<?php

namespace Onboarding\Exercicio4\Database\Factories;

use Faker\Generator;
use Onboarding\Exercicio4\Database\ProductDb;
use Onboarding\Exercicio4\Dto\ProdutoDto;

class ProdutoFactory extends BaseFactory
{
    public string $dtoClass = ProdutoDto::class;
    public string $dbClass = ProductDb::class;

    protected function make(Generator $faker): array
    {
        return [
            'name' => $faker->name,
            'price' => $faker->randomFloat(nbMaxDecimals: 2, min: 1.00, max: 1000.00)
        ];
    }
}