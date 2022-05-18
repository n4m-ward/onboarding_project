<?php

namespace tests\Exercicio3\Utils;

use Onboarding\Exercicio1\Adders\NumberFilter\ThreeOrFiveNumberFilter;
use Onboarding\Exercicio3\Utils\NumberUtils;
use PHPUnit\Framework\TestCase;

class NumberUtilsTest extends TestCase
{
    public NumberUtils $numberUtils;

    public function setUp(): void
    {
        parent::setUp();
        $numberFilter = new ThreeOrFiveNumberFilter();
        $this->numberUtils = new NumberUtils($numberFilter);
    }

    /**
     * @return void
     */
    public function testIsAnPrimeNumberReturnTrue(): void
    {
        $primeNumber = 7;
        $result = $this->numberUtils->isAnPrimeNumber($primeNumber);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testIsAnPrimeNumberReturnFalse(): void
    {
        $primeNumber = 10;
        $result = $this->numberUtils->isAnPrimeNumber($primeNumber);

        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testNumberIsMultipleOfThreeOrFiveReturnTrue(): void
    {
        $number = 15;
        $result = $this->numberUtils->numberIsMultipleOfThreeOrFive($number);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testNumberIsMultipleOfThreeOrFiveReturnFalse(): void
    {
        $number = 7;
        $result = $this->numberUtils->numberIsMultipleOfThreeOrFive($number);

        $this->assertFalse($result);
    }
}
