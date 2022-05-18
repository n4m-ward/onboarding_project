<?php

namespace Onboarding\Exercicio3;

use Exception;
use Onboarding\Exercicio2\HappyNumberService;
use Onboarding\Exercicio3\Utils\NumberUtils;
use Onboarding\Exercicio3\Utils\WordUtils;
use Onboarding\Exercicio3\ValueObjects\Letter;
use Onboarding\Exercicio3\ValueObjects\Word;

class WordInNumberService
{
    public function __construct(
        public HappyNumberService $happyNumberService,
        public NumberUtils $numberUtils,
    )
    {}

    public const LETTER_VALUE_MAPPING = [
        'a' => 1,
        'b' => 2,
        'c' => 3,
        'd' => 4,
        'e' => 5,
        'f' => 6,
        'g' => 7,
        'h' => 8,
        'i' => 9,
        'j' => 10,
        'k' => 11,
        'l' => 12,
        'm' => 13,
        'n' => 14,
        'o' => 15,
        'p' => 16,
        'q' => 17,
        'r' => 18,
        's' => 19,
        't' => 20,
        'u' => 21,
        'v' => 22,
        'w' => 23,
        'x' => 24,
        'y' => 25,
        'z' => 26,
    ];

    /**
     * @throws Exception
     */
    public function getLetterValue(string $letter): int
    {
        $isAnUpperCaseLetter = WordUtils::isAnUppercaseLetter($letter);
        $letterValue = self::LETTER_VALUE_MAPPING[strtolower($letter)] ?? null;

        if (is_null($letterValue)) {
           throw new Exception('Por favor use apenas letras de a ~ Z');
        }

        if ($isAnUpperCaseLetter) {
            $totalOfWords = count(self::LETTER_VALUE_MAPPING);

            return $totalOfWords + $letterValue;
        }

        return $letterValue;
    }

    /**
     * @throws Exception
     */
    public function getLetterInfos(string $letter): Letter
    {
        $letterNumber = $this->getLetterValue($letter);

        return new Letter(
            letter: $letter,
            letterNumber: $letterNumber,
            isAnHappyNumber: $this->happyNumberService->isAnHappyNumber($letterNumber),
            isAnPrimeNumber: $this->numberUtils->isAnPrimeNumber($letterNumber),
            isMultipleOfThreeOrFive: $this->numberUtils->numberIsMultipleOfThreeOrFive($letterNumber),
        );
    }

    /**
     * @return array<Letter>
     * @throws Exception
     */
    public function getWordLettersInfoInArray(string $word): array
    {
        $letterArrayToReturn = [];
        $splittedWord = str_split($word);

        foreach ($splittedWord as $letter) {
            $letterArrayToReturn[] = $this->getLetterInfos(letter: $letter);
        }

        return $letterArrayToReturn;
    }

    /**
     * @throws Exception
     */
    public function getWordInfo(string $word): Word
    {
        $letterArray = $this->getWordLettersInfoInArray(word: $word);

        return new Word(
            word: $word,
            totalWordValue: $this->getWordTotalValueByLettersArray(letters: $letterArray),
            letters: $letterArray,
        );
    }

    /**
     * @param array<Letter> $letters
     */
    public function getWordTotalValueByLettersArray(array $letters): int
    {
        $numberToSumAndReturn = 0;
        foreach ($letters as $letter) {
            $numberToSumAndReturn += $letter->letterNumber;
        }

        return $numberToSumAndReturn;
    }
}
