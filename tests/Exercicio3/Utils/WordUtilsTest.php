<?php


namespace tests\Exercicio3\Utils;

use Onboarding\Exercicio3\Utils\WordUtils;
use PHPUnit\Framework\TestCase;

class WordUtilsTest extends TestCase
{
    /**
     * @return void
     */
    public function testisAnUppercaseLetterReturnTrue(): void
    {
        $letter = 'A';
        $result = WordUtils::isAnUppercaseLetter($letter);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testisAnUppercaseLetterReturnFalse(): void
    {
        $letter = 'a';
        $result = WordUtils::isAnUppercaseLetter($letter);

        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testRemoveUnwantedCharactersWork(): void
    {
        $letterWithUnwantedCharacters = 'Fóo98 23@!&*|';
        $expectedResult = 'Foo';

        $result = WordUtils::removeUnwantedCharacters($letterWithUnwantedCharacters);

        $this->assertEquals($expectedResult, $result);
    }
}
