<?php

namespace tests\Exercicio4\TestUtils;
class DbTransaction
{
    private const ALL_DATABASES = [
        'cart',
        'product',
        'user',
    ];
    private const FILE_SULFIX = '.json';

    public static function rollback(): void
    {
        foreach (self::ALL_DATABASES as $table) {
            $modelPath = self::getModelPath($table);
            self::clearDatabase($modelPath);
        }
    }

    private static function getModelPath(string $table): string
    {
        return __DIR__
            . '/../../../app/Exercicio4/Database/Models/'
            . $table
            . self::FILE_SULFIX;
    }

    private static function clearDatabase(string $modelPath): void
    {
        $contentToSubstitute = '[]';
        $fp = fopen($modelPath, "w+");
        fwrite($fp, $contentToSubstitute);
        fclose($fp);
    }
}