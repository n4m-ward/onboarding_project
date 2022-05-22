<?php

namespace Onboarding\Exercicio4\Services;

use Exception;
use Onboarding\Exercicio4\Database\CartDb;
use Onboarding\Exercicio4\Dto\ProductDto;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;
use Onboarding\Exercicio4\Repositories\CartRepository;
use Onboarding\Exercicio4\Utils\DtoUtils;
use Onboarding\Exercicio4\ValueObjects\Carrinho;

class CartService
{
    public function __construct(
        private readonly CartRepository             $cartRepository,
        private readonly CartValueCalculatorService $calculatorService,
    ) {
    }

    /**
     * @param int $userId
     * @param array<ProductDto> $products
     * @return void
     * @throws Exception
     */
    public function addItemToCart(int $userId, array $products): void
    {
        $cart = $this->cartRepository->getCartByUserId($userId);
        $cartIsEmpty = empty($cart);

        if ($cartIsEmpty) {
            $this->cartRepository->createNewCart(userId: $userId, products: $products);
            return;
        }

        $this->cartRepository->addProductsToCart(userId: $userId, products: $products);
    }

    public function getCartByUserId(int $userId): Carrinho
    {
        $carrinho = $this->cartRepository->getCartByUserId($userId);
        $totalValue = 0.0;
        $cartIsEmpty = empty($carrinho);

        if (!$cartIsEmpty) {
            $carrinho->wishList = DtoUtils::formatFieldWishList($carrinho->wishList);
            $totalValue = $this->calculatorService->calculateCartValue($carrinho);
        }

        return new Carrinho(
            totalValue: $totalValue,
            cart: $carrinho,
        );
    }

    /**
     * @throws Exception
     */
    public function removeCartItemByUserId(int $userId, int $productId, int $quantity): void
    {
        $cart = $this->getCartByUserId($userId);
        $cart = $cart->cart;
        $wishlistWithRemovedQuantities = $this
            ->getProductsWithSubtractedQuantities(
                wishlist: $cart->wishList,
                productId: $productId,
                quantity: $quantity
            );
        $cart->wishList = $this
            ->getWishListWithoutQuantityLessThanZero($wishlistWithRemovedQuantities);

        $this->cartRepository->updateCartById($cart->id, $cart);
    }

    /**
     * @param array<ProdutoQuantityDto> $wishlist
     * @return array<ProdutoQuantityDto>
     */
    public function getWishListWithoutQuantityLessThanZero(array $wishlist): array
    {
        return array_filter($wishlist, function (ProdutoQuantityDto $produtoQuantityDto) {
            return $produtoQuantityDto->quantity > 0;
        });
    }

    /**
     * @param array<ProdutoQuantityDto> $wishlist
     * @param int $productId
     * @param int $quantity
     * @return array<ProdutoQuantityDto>
     */
    private function getProductsWithSubtractedQuantities(array $wishlist, int $productId, int $quantity): array
    {
        return array_map(function (ProdutoQuantityDto $produtoQuantityDto) use ($quantity, $productId) {
            $productIdMatch = $produtoQuantityDto->product->id == $productId;
            if ($productIdMatch) {
                $produtoQuantityDto->quantity -= $quantity;
            }

            return $produtoQuantityDto;
        }, $wishlist);
    }

    public function clearCartProductsByUserId(int $userId): void
    {
        $this->cartRepository->clearCartByUserId($userId);
    }
}
