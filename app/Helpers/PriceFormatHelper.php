<?php

namespace App\Helpers;

class PriceFormatHelper
{
    public static function prepareToDb(string $price): float
    {
        $priceSplitted = explode(separator: ' ', string: $price);
        $price = $priceSplitted[1];
        $price = str_replace(
            search: ',',
            replace: '.',
            subject: $price
        );
        return (float) $price;
    }

    public static function prepareToDisplay(string $price): string
    {
        $price = (float) $price;
        return 'R$ ' . number_format(
            num: $price,
            decimals: 2,
            decimal_separator: ',',
            thousands_separator: '.'
        );
    }
}
