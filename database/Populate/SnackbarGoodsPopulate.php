<?php

namespace Database\Populate;

use App\Models\SnackbarGood;

class SnackbarGoodsPopulate
{
    public static function populate(): void
    {
        $goods = [
            'Coxinha' => ['price' => 4.5, 'quantity' => 10],
            'Hamburgão' => ['price' => 5.25, 'quantity' => 3],
            'Folhado de Calabresa' => ['price' => 6, 'quantity' => 4],
            'Pão de Queijo' => ['price' => 2.5, 'quantity' => 20],
            'Empada' => ['price' => 3.75, 'quantity' => 15],
            'Pastel' => ['price' => 4, 'quantity' => 12],
            'Kibe' => ['price' => 3, 'quantity' => 8],
            'Esfirra' => ['price' => 3.5, 'quantity' => 10],
        ];

        $count = 0;
        foreach($goods as $goodDescription => $details) {
            $snackbarGood = new SnackbarGood(params: [
                'price' => $details['price'],
                'description' => $goodDescription
            ]);
            $snackbarGood->save();
            $count++;
        }

        echo "Snackbar Goods populated with $count records.\n";
    } 
}