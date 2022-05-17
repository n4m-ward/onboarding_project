<?php

namespace tests\Exercicio1\Adders\NumberFilter;

use Onboarding\Exercicio1\Adders\NumberFilter\BaseNumberFilter;

class BaseNumberFilterForTest extends BaseNumberFilter
{

    /**
     * @param array<int> $arrayToFilter
     * @return  array<int>
     */
    public function filterNumbers(array $arrayToFilter): array
    {
        return [];
    }
}
