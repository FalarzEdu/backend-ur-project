<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Core\Database\ActiveRecord\Model;
use Lib\Validations;

/**
 * @param int $user_id
 * @param int $meal_id
 * @param int $has_assistance
 */
class BuffetReservation extends Model
{
    protected static string $table = 'buffet_reservations';

    protected static array $columns = [
        'user_id',
        'meal_id',
        'has_assistance'
    ];

    protected int $user_id;
    protected int $meal_id;
    protected int $has_assistance = 0;

    public function __construct(array $params)
    {
        parent::__construct(params: $params);
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(related: 'meals', foreignKey: 'meal_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: 'users', foreignKey: 'user_id');
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'user_id', obj: $this);
        Validations::notEmpty(attribute: 'meal_id', obj: $this);
    }
}
