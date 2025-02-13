<?php

namespace App\Models;

use Core\Database\ActiveRecord\Model;
use DateTime;
use Lib\Validations;

/**
 * @property int id
 * @property int $feedback_id;
 * @property string $path;
 */
class Image extends Model
{
    protected static string $table = 'feedback_images';

    protected static array $columns = [
        'id',
        'feedback_id',
        'path'
    ];

    protected ?int $id = null;
    protected ?int $feedback_id = null;
    protected ?string $path = null;

    public function __construct(array $params)
    {
        $this->feedback_id = $params['feedback_id'];
        parent::__construct(params: $params);
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'feedback_id', obj: $this);
        Validations::notEmpty(attribute: 'path', obj: $this);
    }

    public function path() {
        return $this->baseDir() . $this->model->image;
    }

    public function baseDir(): string {
        return "/assets/uploads/feedback/{$this->model->id}";
    }
}
