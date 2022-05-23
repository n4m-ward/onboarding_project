<?php

namespace Onboarding\Exercicio4\Services;

use Onboarding\Exercicio4\Dto\CartDto;
use Onboarding\Exercicio4\Integrators\ShippingCalculator;
use Onboarding\Exercicio4\Repositories\UserRepository;

class CartValueCalculatorService
{
    public function __construct(
        private ShippingCalculator $shippingCalculator,
        private UserRepository $userRepository
    ) {
    }
    public function calculateCartValue(CartDto $carrinho): float
    {
        $productsValue = 0.0;
        foreach ($carrinho->wishList as $product) {
            $productsValue += $product->product->price * $product->quantity;
        }
        $shippingValue = $this->getCartShippingValue($carrinho, $productsValue);

        return $productsValue + $shippingValue;
    }

    private function getCartShippingValue(CartDto $carrinhoDto, float $productTotalValue): float
    {
        $shippingValue = 0.0;
        $productValueIsLessThan100 = (int) $productTotalValue < 100;
        $cartIsNoyEmpty = !empty($carrinhoDto->wishList);
        if ($productValueIsLessThan100 && $cartIsNoyEmpty) {
            $user = $this->userRepository->getUserById($carrinhoDto->userId);
            $shippingValue = $this
                ->shippingCalculator
                ->calculateShipppingByCep($user->cep);
        }

        return $shippingValue;
    }
}
