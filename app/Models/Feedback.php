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
    private array $image = [];

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

    public function image(): HasMany
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
        parent::__set($property, $value);
    }

    public function imagesMultiple(array $images)
    {
        foreach ($images as $img) {
            $this->addImage($img);
        }
    }

    public function addImage(array $image): void
    {
        if (!empty($this->getTmpFilePath($image))) {
            move_uploaded_file($this->getTmpFilePath($image), $this->getAbsolutePath($image));
        }
    }

    private function getTmpFilePath(array $image)
    {
        return $image['tmp_name'];
    }

    private function getFileName(array $image): string
    {
        foreach ($image as $p) {
            dd($p);
            $file_name_splitted = explode('.', $p['name']);
            $file_extension = end($file_name_splitted);
            return 'banana.' . $file_extension;
        }
    }

    private function getAbsolutePath(array $image): string
    {
        return $this->storeDir() . '/' . $this->getFileName($image);
    }

    private function baseDir(): string
    {

        return "/assets/uploads/";
    }

    private function storeDir(): string
    {
        $path = Constants::rootPath()->join('public' . $this->baseDir());
        if (!is_dir($path)) {
            mkdir(directory: $path, recursive: true);
        }

        return $path;
    }
}
