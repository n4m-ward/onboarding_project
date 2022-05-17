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
}