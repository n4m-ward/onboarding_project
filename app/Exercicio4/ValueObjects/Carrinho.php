<?php

namespace Onboarding\Exercicio4\ValueObjects;

use Onboarding\Exercicio4\Dto\CartDto;

class Carrinho
{
    public function __construct(
        public readonly float    $totalValue,
        public readonly ?CartDto $cart = null,
    ) {
    }
}
