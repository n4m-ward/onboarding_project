<?php

namespace Onboarding\Exercicio4\Database\Factories;

use Faker\Generator;
use Onboarding\Exercicio4\Database\CartDb;
use Onboarding\Exercicio4\Database\ProductDb;
use Onboarding\Exercicio4\Database\UserDb;
use Onboarding\Exercicio4\Dto\CarrinhoDto;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;

class CarrinhoFactory extends BaseFactory
{
    public string $dtoClass = CarrinhoDto::class;
    public string $dbClass = CartDb::class;

    protected function make(Generator $faker): array
    {
        $produtoQuantity = (new ProdutoQuantityDto())
            ->attachValues([
                'product' => ProductDb::factory(),
                'quantity' => $faker->numberBetween(1, 10)
            ]);

        return [
            'userId' => UserDb::factory()->id,
            'wishList' => [$produtoQuantity],
        ];
    }
}