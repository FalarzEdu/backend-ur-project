<?php

namespace App\Controllers;

use App\Models\SnackbarGood;
use Core\Http\Controllers\Controller;
use Core\Http\Request;

class SnackbarGoodsControllerAjax extends Controller
{
    /**
     * Returns an array of goods containing all data related to them.
     * @return void
     */
    public function prices(): void
    {
        $prices = SnackbarGood::all();
        $pricesArray = array_map(
            callback: fn($good): array => [
                'id' => $good->id,
                'price' => $good->price,
                'description' => $good->description
            ],
            array: $prices
        );

        echo json_encode(value: [
            'success' => true,
            'data' => $pricesArray
        ]);
    }
}
