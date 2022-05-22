<?php

namespace Onboarding\Exercicio4\Dto;

use Onboarding\Exercicio4\Interfaces\Dto;

class BaseDto implements Dto
{
    /**
     * @param array<mixed> $values
     * @return $this
     */
    public function attachValues(array $values): static
    {
        foreach ($values as $property => $propertyValue) {
            if (property_exists($this, $property)) {
                $this->{$property} = $propertyValue;
            }
        }

        return $this;
    }
}
