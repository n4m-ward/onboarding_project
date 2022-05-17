<?php

namespace tests\Adders\NumberFilter;

use PHPUnit\Framework\TestCase;

class BaseNumberFilterTest extends TestCase
{
    private BaseNumberFilterForTest $baseNumberFilter;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseNumberFilter = new BaseNumberFilterForTest();
    }

    public function testIsNumberMultipleReturnsTrue(): void
    {
        $isFifityMultipleOfFive = $this->baseNumberFilter->numberIsMultiple(number: 15, multiple: 5);

        $this->assertTrue($isFifityMultipleOfFive);
    }

    public function testIsNumberMultipleReturnsFalse(): void
    {
        $isFifityMultipleOfTwo = $this->baseNumberFilter->numberIsMultiple(number: 15, multiple: 2);

        $this->assertFalse($isFifityMultipleOfTwo);
    }
}
