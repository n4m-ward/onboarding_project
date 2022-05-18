<?php

namespace tests\Exercicio3;

use Exception;
use Onboarding\Exercicio1\Adders\NumberFilter\ThreeOrFiveNumberFilter;
use Onboarding\Exercicio2\HappyNumberService;
use Onboarding\Exercicio3\Utils\NumberUtils;
use Onboarding\Exercicio3\ValueObjects\Letter;
use Onboarding\Exercicio3\WordInNumberService;
use PHPUnit\Framework\TestCase;

class WordInNumberServiceTest extends TestCase
{
    /**
     * @var WordInNumberService
     */
    private WordInNumberService $wordInNumberService;

    protected function setUp(): void
    {
        parent::setUp();
        $happyNumberService = new HappyNumberService();
        $threeOrFiveNumberFilter = new ThreeOrFiveNumberFilter();
        $numberUtils = new NumberUtils($threeOrFiveNumberFilter);
        $this->wordInNumberService = new WordInNumberService(
            happyNumberService: $happyNumberService,
            numberUtils: $numberUtils
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLetterValueWorks(): void
    {
        $letter = 'a';
        $expectedLetterValue = 1;

        $result = $this->wordInNumberService->getLetterValue(letter: $letter);

        $this->assertEquals($expectedLetterValue, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLetterValueWorksWithUpperCaseLetter(): void
    {
        $letter = 'A';
        $expectedLetterValue = 27;

        $result = $this->wordInNumberService->getLetterValue(letter: $letter);

        $this->assertEquals($expectedLetterValue, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLetterValueThrowAnExceptionIfReciveAnInvalidCharacter(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Por favor use apenas letras de a ~ Z');
        $invalidLetter = '@';

        $this->wordInNumberService->getLetterValue($invalidLetter);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLetterInfosWork(): void
    {
        $expectedLetterNumber = 7;
        $letter = $this->wordInNumberService->getLetterInfos(letter: 'g');

        $this->assertEquals($expectedLetterNumber, $letter->letterNumber);
        $this->assertTrue($letter->isAnHappyNumber);
        $this->assertTrue($letter->isAnPrimeNumber);
        $this->assertFalse($letter->isMultipleOfThreeOrFive);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetWordLetterInfoInArrayGetCorrectQuantityOfLetters(): void
    {
        $word = 'foo';
        $qtyWordLetters = strlen($word);
        $lettersArray = $this->wordInNumberService->getWordLettersInfoInArray(word: $word);

        $this->assertCount($qtyWordLetters, $lettersArray);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetWordInfoWorks(): void
    {
        $word = 'bar';
        $wordInfo = $this->wordInNumberService->getWordInfo(word: $word);

        $this->assertEquals($word, $wordInfo->word);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetWordInfoBringsCorrectWordValue(): void
    {
        $word = 'bar';
        $expectedWordValue = 21;
        $wordInfo = $this->wordInNumberService->getWordInfo(word: $word);

        $this->assertEquals($expectedWordValue, $wordInfo->totalWordValue);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetWordInfoBringsCorrectWordValueBasedOnUpperCaseLetters(): void
    {
        $word = 'BAR';
        $expectedWordValue = 99;
        $wordInfo = $this->wordInNumberService->getWordInfo(word: $word);

        $this->assertEquals($expectedWordValue, $wordInfo->totalWordValue);
    }

    /**
     * @return void
     */
    public function testgetWordTotalValueByLettersArrayWorks(): void
    {
        $expectedResult = 4;
        $lettersArrayMock = [
            new Letter(letter: 'a',
                letterNumber: 2,
                isAnHappyNumber: true,
                isAnPrimeNumber: false,
                isMultipleOfThreeOrFive: false
            ),
            new Letter(
                letter: 'a',
                letterNumber: 2,
                isAnHappyNumber: true,
                isAnPrimeNumber: false,
                isMultipleOfThreeOrFive: false
            ),
        ];
        $result = $this->wordInNumberService->getWordTotalValueByLettersArray($lettersArrayMock);

        $this->assertEquals($expectedResult, $result);
    }
}
