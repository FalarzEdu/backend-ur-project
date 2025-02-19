<?php

namespace App\Models;

use Core\Constants\Constants;
use Core\Database\ActiveRecord\BelongsTo;
use Exception;
use Lib\Validations;

/**
 * @property int $feedback_id;
 */
class FeedbackImage extends Image
{
    protected static string $table = 'feedback_images';

    protected static array $columns = [
        'id',
        'feedback_id',
        'path'
    ];

    protected ?int $id = null;
    protected ?int $feedback_id;
    protected ?string $path;

    public function __construct(array $params)
    {
        $this->feedback_id = $params['feedback_id'];
        parent::__construct(params: $params);
    }

    public function feedback(): BelongsTo {
        return $this->belongsTo(
            related: Feedback::class,
            foreignKey: 'id_feedback'
        );
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'feedback_id', obj: $this);
        Validations::notEmpty(attribute: 'path', obj: $this);
    }
}
