<?php

namespace tests\Exercicio1\Adders\NumberFilter;

use Onboarding\Exercicio1\Adders\NumberFilter\ThreeOrFiveAndSevenNumberFilter;
use PHPUnit\Framework\TestCase;

class ThreeOrFiveAndSevenNumberFilterTest extends TestCase
{
    private ThreeOrFiveAndSevenNumberFilter $numberFilter;

    public function setUp(): void
    {
        parent::setUp();
        $this->numberFilter = new ThreeOrFiveAndSevenNumberFilter();
    }

    public function testFilterNumberWorks(): void
    {
        $arrayToFilter = [20, 21, 35, 40];
        $filteredArray = $this->numberFilter->filterNumbers($arrayToFilter);

        $this->assertTrue(in_array(21, $filteredArray));
        $this->assertTrue(in_array(35, $filteredArray));
        $this->assertFalse(in_array(20, $filteredArray));
        $this->assertFalse(in_array(40, $filteredArray));
    }
}
