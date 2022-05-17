<?php

namespace tests\Exercicio1\Adders;

use Exception;
use Onboarding\Exercicio1\Adders\MultipleNumbersAdder;
use PHPUnit\Framework\TestCase;

class MultipleNumbersAdderTest extends TestCase
{
    private MultipleNumbersAdder $multipleNumberAdder;

    public function setUp(): void
    {
        parent::setUp();
        $this->multipleNumberAdder = new MultipleNumbersAdder();
    }

    /**
     * @throws Exception
     */
    public function testMultipleOfThreeOrFiveWorksInRangeOneThousand(): void
    {
        $expectedResult = 233168;
        $resultOfSum = $this->multipleNumberAdder
            ->setRange(initialValue: 1, finalValue: 1000)
            ->getSumOfMultiples();

        $this->assertEquals($expectedResult, $resultOfSum['multipleOfThreeOrFive']);
    }

    /**
     * @throws Exception
     */
    public function testMultipleOfThreeAndFiveWorksInRangeOneThousand(): void
    {
        $expectedResult = 33165;
        $resultOfSum = $this->multipleNumberAdder
            ->setRange(initialValue: 1, finalValue: 1000)
            ->getSumOfMultiples();

        $this->assertEquals($expectedResult, $resultOfSum['multipleOfThreeAndFive']);
    }

    /**
     * @throws Exception
     */
    public function testMultipleOfThreeOrFiveAndSevenWorksInRangeOneThousand(): void
    {
        $expectedResult = 33173;
        $resultOfSum = $this->multipleNumberAdder
            ->setRange(initialValue: 1, finalValue: 1000)
            ->getSumOfMultiples();

        $this->assertEquals($expectedResult, $resultOfSum['multipleOfThreeOrFiveAndSeven']);
    }
}
