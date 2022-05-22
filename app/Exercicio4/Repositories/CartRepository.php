<?php

namespace Onboarding\Exercicio4\Repositories;

use Exception;
use Onboarding\Exercicio4\Database\CartDb;
use Onboarding\Exercicio4\Dto\CartDto;
use Onboarding\Exercicio4\Dto\ProductDto;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;
use Onboarding\Exercicio4\Utils\DtoUtils;

class CartRepository
{
    public function getCartByUserId(int $userId): ?CartDto
    {
        return (new CartDb())->getAll()
            ->where('userId', '=', $userId)
            ->first();
    }

    /**
     * @param int $userId
     * @param array<ProductDto> $products
     * @return void
     * @throws Exception
     */
    public function createNewCart(int $userId, array $products): void
    {
        $productQuantityArray = [];
        foreach ($products as $product) {
            $productQuantityDto = (new ProdutoQuantityDto())
                ->attachValues(['product' => $product]);
            $productQuantityArray[] = $productQuantityDto;
        }
        $cartDto = new CartDto();
        $cartDto->userId = $userId;
        $cartDto->wishList = $productQuantityArray;

        (new CartDb())->insert($cartDto);
    }

    /**
     * @param int $userId
     * @param array<ProductDto> $products
     * @return void
     * @throws Exception
     */
    public function addProductsToCart(int $userId, array $products): void
    {
        $carrinho = (new CartDb())->getAll()
            ->where('userId', '=', $userId)
            ->first();
        $formatedFieldwishList = DtoUtils::formatFieldWishList($carrinho->wishList);
        $carrinho->wishList = $this->getFieldWishListPopuledWithNewProducts(
            $products,
            $formatedFieldwishList
        );
        (new CartDb())
            ->where('id', '=', $carrinho->id)
            ->update($carrinho);
    }

    /**
     * @param array<ProductDto> $products
     * @param array<ProdutoQuantityDto> $cart
     * @return array<ProdutoQuantityDto>
     */
    public function getFieldWishListPopuledWithNewProducts(array $products, array $cart): array
    {
        $productsThatExistInCart = $this->
        getProductsThatExistInCartWithNewQuantity($products, $cart);
        $productsThatNoExistInCart = $this
            ->getProductsThatDoesNotExistsInCart($products, $cart);

        return array_merge($productsThatExistInCart, $productsThatNoExistInCart);
    }

    /**
     * @param ProductDto $product
     * @param array<ProdutoQuantityDto> $cart
     * @return ProdutoQuantityDto|null
     */
    private function getProductQuantityInCart(ProductDto $product, array $cart): ?ProdutoQuantityDto
    {
        $arrayContent = array_filter(
            $cart,
            function (ProdutoQuantityDto $productQuantity) use ($product) {
                return $productQuantity->product->name === $product->name
                && $productQuantity->product->price === $product->price;
            }
        );

        return empty($arrayContent)
            ? null
            : $arrayContent[0];
    }

    /**
     * @param array<ProductDto> $products
     * @param array<ProdutoQuantityDto> $cart
     * @return array<ProdutoQuantityDto>
     */
    private function getProductsThatExistInCartWithNewQuantity(array $products, array $cart): array
    {
        return array_map(
            function (ProdutoQuantityDto $productQuantity) use ($products) {
                foreach ($products as $product) {
                    $productNameMatch = $product->name === $productQuantity->product->name;
                    $productValueMatch = $product->price === $productQuantity->product->price;
                    if ($productNameMatch && $productValueMatch) {
                        $productQuantity->quantity ++;
                    }
                }

                return $productQuantity;
            },
            $cart
        );
    }

    /**
     * @param array<ProductDto> $products
     * @param array<ProdutoQuantityDto> $cart
     * @return array<ProdutoQuantityDto>
     */
    private function getProductsThatDoesNotExistsInCart(array $products, array $cart): array
    {
        $productsThatDoesNotExistInCart = $this
            ->filterByProductsNonExistentInCart($products, $cart);

        return $this->groupProductsByQuantity($productsThatDoesNotExistInCart);
    }

    /**
     * @param array<ProductDto> $products
     * @param array<ProdutoQuantityDto> $cart
     * @return array<ProductDto>
     */
    private function filterByProductsNonExistentInCart(array $products, array $cart): array
    {
        return array_filter($products, function (ProductDto $product) use ($cart) {
            $productQuantity = $this->getProductQuantityInCart($product, $cart);
            $productQuantityExist = !empty($productQuantity);

            return !$productQuantityExist;
        });
    }


    /**
     * @param array<ProductDto> $productsArray
     * @return array<ProdutoQuantityDto>
     */
    private function groupProductsByQuantity(array $productsArray): array
    {
        $productsGroupedByEquals = $this->getProductGroupedByEquals($productsArray);
        return array_map(
            function (array $groupedProducts) {
                $product = $groupedProducts[0];
                $productQuantity = count($groupedProducts);
                $productQuantityDto = (new ProdutoQuantityDto());
                $productQuantityDto->product = $product;
                $productQuantityDto->quantity = $productQuantity;


                return $productQuantityDto;
            },
            $productsGroupedByEquals
        );
    }

    public function clearCartByUserId(int $userId): void
    {
        $cartDb = new CartDb();
        $cart = $cartDb->getAll()
            ->where('userId', '=', $userId)
            ->first();
        $cart->wishList = [];
        $this->updateCartById($cart->id, $cart);
    }

    public function updateCartById(int $cartId, CartDto $cart): void
    {
        (new CartDb())
            ->where('id', '=', $cartId)
            ->update($cart);
    }

    private function getProductGroupedByEquals(array $productsArray): array
    {
        $arrayGroupedByRepeatedProducts = [];
        foreach ($productsArray as $product) {
            $arrayGroupedByRepeatedProducts[$product->name][] = $product;
        }

        return $arrayGroupedByRepeatedProducts;
    }
}
