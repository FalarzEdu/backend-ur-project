<?php

namespace App\Models;

use App\Services\ProfileAvatar;
use Core\Database\ActiveRecord\BelongsToMany;
use Core\Database\ActiveRecord\HasMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $academic_register
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 * @property string $phone
 */
class User extends Model
{
    protected static string $table = 'users';
    protected static array $columns = ['name', 'academic_register', 'email', 'password', 'phone'];

    protected ?string $password = null;
    protected ?string $password_confirmation = null;

    public function feedbacks(): HasMany
    {
        return $this->hasMany(
            related: Feedback::class,
            foreignKey: 'id_user'
        );
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'name', obj: $this);
        Validations::notEmpty(attribute: 'email', obj: $this);

        Validations::uniqueness(fields: 'email', object: $this);

        if ($this->newRecord()) {
            Validations::passwordConfirmation(obj: $this);
        }
    }

    public function authenticate(string $password): bool
    {
        if ($this->password == null) {
            return false;
        }

        return password_verify(password: $password, hash: $this->password);
    }

    public static function findByEmail(string $email): User | null
    {
        return User::findBy(['email' => $email]);
    }

    public function __set(string $property, mixed $value): void
    {
        parent::__set($property, $value);

        if (
            $property === 'password' &&
            $this->newRecord() &&
            $value !== null && $value !== ''
        ) {
            $this->password = password_hash($value, PASSWORD_DEFAULT);
        }
    }

    // public function avatar(): ProfileAvatar
    // {
    //     return new ProfileAvatar($this);
    // }
}
