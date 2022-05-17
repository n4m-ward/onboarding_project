<?php


use Onboarding\Exercicio2\HappyNumberService;
use PHPUnit\Framework\TestCase;

class HappyNumberServiceTest extends TestCase
{
    private HappyNumberService $happyNumberService;

    public function setUp(): void
    {
        parent::setUp();
        $this->happyNumberService = new HappyNumberService();
    }

    public function testIsAnHappyNumberServiceReturnTrue(): void
    {
        $numberToVerify = 7;
        $isAnHappyNumber = $this->happyNumberService->isAnHappyNumber($numberToVerify);

        $this->assertTrue($isAnHappyNumber);
    }

    public function testIsAnHappyNumberServiceReturnFalse(): void
    {
        $numberToVerify = 2;
        $isAnHappyNumber = $this->happyNumberService->isAnHappyNumber($numberToVerify);

        $this->assertFalse($isAnHappyNumber);
    }

    /**
     * @throws ReflectionException
     */
    public function testsquareAndSumEachDigitOfNumberBringsCorrectResultForTwoDigitsNumber(): void
    {
        $expectedResult = 8;
        $numberToSquare = 22;
        $result = $this->invokeNonPublicProperty(
            $this->happyNumberService,
            'squareAndSumEachDigitOfNumber',
            [$numberToSquare]
        );

        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @throws ReflectionException
     */
    public function testsquareAndSumEachDigitOfNumberBringsCorrectResultForOneDigitNumber(): void
    {
        $expectedResult = 4;
        $numberToSquare = 2;
        $result = $this->invokeNonPublicProperty(
            $this->happyNumberService,
            'squareAndSumEachDigitOfNumber',
            [$numberToSquare]
        );

        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @throws ReflectionException
     */
    public function testsquareNumberWorks(): void
    {
        $expectedResult = 4;
        $numberToSquare = 2;
        $result = $this->invokeNonPublicProperty(
            $this->happyNumberService,
            'squareNumber',
            [$numberToSquare]
        );

        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @throws ReflectionException
     */
    function invokeNonPublicProperty($object, $methodName, array $arguments = [])
    {
        $class = new ReflectionClass($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return empty($arguments)
            ? $method->invoke($object)
            : $method->invokeArgs($object, $arguments);
    }
}