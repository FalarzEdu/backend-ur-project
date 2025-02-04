<?php

namespace App\Helpers;

use Core\Constants\Constants;
use PhpParser\Node\Stmt\Const_;

class Translation
{
    /** @var array<string, array<string, string>> */
    protected static array $translations;

    public static function loadTranslations(): void
    {
        $file_path = Constants::rootPath()->join('config/translations.json');
        self::$translations = json_decode(
            json: file_get_contents(filename: $file_path),
            associative: true
        );
    }

    public static function translate(
        string $key,
        string $value
    ): string {
        if (empty(self::$translations)) {
            self::loadTranslations();
        }

        if (
            isset(self::$translations[$key]) &&
            isset(self::$translations[$key][$value])
        ) {
            return self::$translations[$key][$value];
        }

        return $value;
    }
}
