<?php

namespace tests\Adders\NumberFilter;

use Onboarding\Adders\NumberFilter\ThreeOrFiveNumberFilter;
use PHPUnit\Framework\TestCase;

class ThreeOrFiveNumberFilterTest extends TestCase
{
    private ThreeOrFiveNumberFilter $numberFilter;

    public function setUp(): void
    {
        parent::setUp();
        $this->numberFilter = new ThreeOrFiveNumberFilter();
    }

    public function testFilterNumberWorks(): void
    {
        $arrayToFilter = range(1, 10);
        $expectedResult = [3, 5, 6, 9, 10];
        $expectedResultSum = array_sum($expectedResult);
        $filteredArray = $this->numberFilter->filterNumbers($arrayToFilter);

        $this->assertEquals($expectedResultSum, array_sum($filteredArray));
    }
}
