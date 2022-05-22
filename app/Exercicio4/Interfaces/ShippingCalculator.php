<?php

namespace Onboarding\Exercicio4\Interfaces;

interface ShippingCalculator
{
    public function calculateShipppingByCep(string $cep): float;
}
