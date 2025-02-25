<?php

namespace App\Models;

use Core\Database\ActiveRecord\Model;
use Lib\Validations;

/**
 * @property int $price
 * @property string $description
 * @property string $image_path
 */
class SnackbarGood extends Model
{
    protected static string $table = 'snackbar_goods';

    protected static array $columns = [
        'price',
        'description',
        'image_path'
    ];

    protected ?string $image_path = 'default';

    public function __construct(array $params)
    {
        parent::__construct(params: $params);
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'price', obj: $this);
        Validations::notEmpty(attribute: 'description', obj: $this);
        Validations::uniqueness(fields: 'description', object: $this);
        // Validations::notEmpty('image_path', $this);
    }
}
