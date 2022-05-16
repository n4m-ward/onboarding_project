<?php

namespace Onboarding\tests\Adders;

use Onboarding\Adders\MultipleNumbersAdder;
use PHPUnit\Framework\TestCase;

class MultipleNumbersAdderTest extends TestCase
{
    private MultipleNumbersAdder $multipleNumberAdder;

    public function setUp(): void
    {
        parent::setUp();
        $this->multipleNumberAdder = new MultipleNumbersAdder();
    }

    public function testGetNumbersMultipleOfThreeAndFiveBringsCorrectResult(): void
    {
        $expectedResult = 23;
        $resultOfSum = $this->multipleNumberAdder->getSumOfMultiplesInRange(1, 10);

        $this->assertEquals($expectedResult, $resultOfSum['multipleOfThreeAndFive']);
    }
}
