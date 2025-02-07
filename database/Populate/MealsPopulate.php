<?php

namespace Database\Populate;

use App\Models\Meal;
use DateTime;

class MealsPopulate
{
    public static function populate(): void
    {
        $dataLunch = [
            'date' => (new DateTime())->format(format: 'Y-m-d'),
            'meal_type' => 'lunch'
        ];
        $dataDinner = [
            'date' => (new DateTime())->format(format: 'Y-m-d'),
            'meal_type' => 'dinner'
        ];

        $meal = new Meal(params: $dataLunch);
        $meal->save();

        $meal = new Meal(params: $dataDinner);
        $meal->save();

        echo "Meals table populated with 2 registers for today date.";
    }
}