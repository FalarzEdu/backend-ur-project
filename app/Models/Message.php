<?php

namespace App\Models;

use Core\Database\ActiveRecord\Model;
use DateTime;
use Lib\Validations;

/**
 * @property int $feedback_id;
 * @property string $content;
 * @property int $admin_id;
 * @property Model $sender_type;
 * @property bool $is_external;
 * @property string $created_on;
 * @property string $updated_on;
 */
class Message extends Model
{
    protected static string $table = 'messages';

    protected static array $columns = [
        'feedback_id',
        'content',
        'admin_id',
        'sender_type',
        'is_external',
        'created_on',
        'updated_on'
    ];

    protected ?int $id = null;
    protected ?int $feedback_id = null;
    protected ?string $content = null;
    protected int $is_external = 0; // No
    protected ?string $created_on = null;
    protected ?string $updated_on = null;

    public function __construct(array $params)
    {
        $this->feedback_id = $params['feedback_id'];
        $this->created_on = (new DateTime())->format(
            format: 'Y-m-d H:i:s'
        );
        parent::__construct(params: $params);
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'sender_type', obj: $this);
    }
}
