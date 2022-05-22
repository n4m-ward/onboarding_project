<?php

namespace Onboarding\Exercicio4\Integrators;

use Onboarding\Exercicio4\Interfaces\ShippingCalculator as ShippingCalculatorInterface;

class ShippingCalculator implements ShippingCalculatorInterface
{
    public function calculateShipppingByCep(string $cep): float
    {
        return 23.50;
    }
}
