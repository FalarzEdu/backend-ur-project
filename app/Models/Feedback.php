<?php

namespace App\Models;

use Core\Constants\Constants;
use Core\Database\ActiveRecord\BelongsTo;
use Core\Database\ActiveRecord\HasMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;
use DateTime;
use PHPUnit\TextUI\Configuration\Constant;

/**
 * @property string $type
 * @property int $id_user
 * @property int $rating
 * @property int $status_id
 * @property string $created_on
 * @property string $updated_on
 * @property int $is_harmfull
 */
class Feedback extends Model
{
    protected ?int $id = null;
    protected ?int $rating = null;
    protected ?int $status_id = 1; // Open
    protected ?string $created_on = null;
    protected ?string $updated_on = null;

    public function __construct(array $params = [])
    {
        $this->created_on = (new DateTime())->format(
            format: 'Y-m-d H:i:s'
        );
        parent::__construct(params: $params);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'id_user'
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(
            related: Message::class,
            foreignKey: 'feedback_id'
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(
            related: Image::class,
            foreignKey: 'feedback_id'
        );
    }

    protected static string $table = 'feedbacks';
    protected static array $columns = [
        'type',
        'id_user',
        'rating',
        'status_id',
        'created_on',
        'updated_on',
        'is_harmfull'
    ];

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'type', obj: $this);
        Validations::notEmpty(attribute: 'status_id', obj: $this);
    }

    public function __set(string $property, mixed $value): void
    {
        parent::__set(property: $property, value: $value);
    }
}
