<?php

namespace App\Models;

use App\Models\User;
use Core\Database\ActiveRecord\BelongsToMany;
use Core\Database\ActiveRecord\Model;
use DateTime;
use Lib\Validations;

/**
 * @property string $date
 * @property string $meal_type
 */
class Meal extends Model
{
    protected static string $table = 'meals';

    protected static array $columns = [
        'date',
        'meal_type'
    ];

    protected ?int $id = null;
    protected string $date;
    protected string $meal_type = 'lunch' | 'dinner';

    public function __construct(array $params)
    {
        $this->meal_type = $params['meal_type'];
        $this->date = (new DateTime())->format(
            format: 'Y-m-d H:i:s'
        );
        parent::__construct(params: $params);
    }

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(
            related: User::class,
            pivot_table: 'buffet_reservations',
            from_foreign_key: 'meal_id',
            to_foreign_key: 'user_id'
        );
    }

    /**
     * Return an array containing two numbers: today lunch's ID and dinner's ID.
     * @return array<number>
     */
    public static function getTodayMealsId(): array
    {
        // $data = $this->where

        $lunchId = self::findBy(conditions: [
            'date' => (new DateTime())->format(format: 'Y-m-d'),
            'meal_type' => 'lunch'
        ])->id;

        $dinnerId = self::findBy(conditions: [
            'date' => (new DateTime())->format(format: 'Y-m-d'),
            'meal_type' => 'dinner'
        ])->id;

        return ['lunchId' => $lunchId, 'dinnerId' => $dinnerId];
    }

    public function validates(): void
    {
        Validations::notEmpty('meal_type', $this);
    }
}
