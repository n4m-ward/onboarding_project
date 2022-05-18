<?php

namespace Onboarding\Exercicio3\Utils;

class WordUtils
{
    private const WORD_TO_REPLACE_ACENTS = [
        "/(á|à|ã|â|ä)/",
        "/(Á|À|Ã|Â|Ä)/",
        "/(é|è|ê|ë)/",
        "/(É|È|Ê|Ë)/",
        "/(í|ì|î|ï)/",
        "/(Í|Ì|Î|Ï)/",
        "/(ó|ò|õ|ô|ö)/",
        "/(Ó|Ò|Õ|Ô|Ö)/",
        "/(ú|ù|û|ü)/",
        "/(Ú|Ù|Û|Ü)/",
        "/(ñ)/",
        "/(Ñ)/"
    ];

    /**
     * @param string $letter
     * @return bool
     */
    public static function isAnUppercaseLetter(string $letter): bool
    {
        $letterUpperCase = strtoupper($letter);

        return $letter == $letterUpperCase;
    }

    /**
     * @param string $text
     * @return string
     */
    public static function removeUnwantedCharacters(string $text): string
    {
        $textWithoutAccents = self::removeWordAccents(word: $text);

        return preg_replace('/[^a-zA-Z]/i', '', $textWithoutAccents);
    }

    /**
     * @param string $word
     * @return string
     */
    public static function removeWordAccents(string $word): string
    {
        return preg_replace(
            self::WORD_TO_REPLACE_ACENTS,
            explode(" ", "a A e E i I o O u U n N"),
            $word
        );
    }
}
