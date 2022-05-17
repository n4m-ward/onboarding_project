<?php

namespace tests\Adders\NumberFilter;

use Onboarding\Adders\NumberFilter\ThreeAndFiveNumberFilter;
use PHPUnit\Framework\TestCase;

class ThreeAndFiveNumberFilterTest extends TestCase
{
    private ThreeAndFiveNumberFilter $numberFilter;

    public function setUp(): void
    {
        parent::setUp();
        $this->numberFilter = new ThreeAndFiveNumberFilter();
    }

    public function testFilterNumberWorks(): void
    {
        $arrayToFilter = [5, 9, 15, 90];
        $result = $this->numberFilter->filterNumbers(arrayToFilter: $arrayToFilter);

        $this->assertTrue(in_array(15, $result));
        $this->assertTrue(in_array(90, $result));
        $this->assertFalse(in_array(5, $result));
        $this->assertFalse(in_array(9, $result));
    }
}
