<?php

namespace App\Helpers;

class Translation
{
    protected static array $translations;

    public static function loadTranslations(): void
    {
        $file_path = __DIR__ ."/../../config/translations.json";
        self::$translations = json_decode(
            json: file_get_contents(filename: $file_path), associative: true
        );  
    }

    public static function translate(
        string $key, string $value
    ): string
    {
        if (empty(self::$translations)) {
            self::loadTranslations();
        }

        return self::$translations[$key][$value] ?? $value;
    }
}