<?php

namespace Onboarding\Exercicio4\Dto;

use Onboarding\Exercicio4\Interfaces\Dto;

class BaseDto implements Dto
{
    public function attachValues(array $values): Dto
    {
        foreach ($values as $property => $propertyValue) {
            if (property_exists($this, $property)) {
                $this->{$property} = $propertyValue;
            }
        }

        return $this;
    }
}
