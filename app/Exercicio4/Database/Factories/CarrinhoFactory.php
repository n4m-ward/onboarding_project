<?php

namespace Onboarding\Exercicio4\Database\Factories;

use Exception;
use Faker\Generator;
use Onboarding\Exercicio4\Database\CartDb;
use Onboarding\Exercicio4\Database\ProductDb;
use Onboarding\Exercicio4\Database\UserDb;
use Onboarding\Exercicio4\Dto\CartDto;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;

class CarrinhoFactory extends BaseFactory
{
    public string $dtoClass = CartDto::class;
    public string $dbClass = CartDb::class;

    /**
     * @throws Exception
     */
    protected function make(Generator $faker): array
    {
        $productQuantityDto = new ProdutoQuantityDto();
        $produtoQuantity = $productQuantityDto
            ->attachValues([
                'product' => (new ProductDb())->factory(),
                'quantity' => $faker->numberBetween(1, 10)
            ]);

        return [
            'userId' => (new UserDb())->factory()->id,
            'wishList' => [$produtoQuantity],
        ];
    }
}
