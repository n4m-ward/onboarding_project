<?php

namespace Onboarding\Exercicio4\Utils;

use Onboarding\Exercicio4\Dto\ProductDto;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;

class DtoUtils
{
    /**
     * @param array<int|ProdutoQuantityDto> $wishList
     * @return array<ProdutoQuantityDto>
     */
    public static function formatFieldWishList(array $wishList): array
    {
        $newArrayToReturn = [];
        foreach ($wishList as $productQuantityDto) {
            $produtoDto = (new ProductDto())
                ->attachValues($productQuantityDto['product']);

            $newArrayToReturn[] = (new ProdutoQuantityDto())->attachValues([
                'product' => $produtoDto,
                'quantity' => $productQuantityDto['quantity']
            ]);
        }

        return $newArrayToReturn;
    }
}
