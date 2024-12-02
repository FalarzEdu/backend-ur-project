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
 * @property string $email
 * @property string $password
 */

class Admin extends Model
{
    protected static string $table = 'admins';
    protected static array $columns = ['name', 'email', 'password'];

    protected ?string $password = null;
    protected ?string $password_confirmation = null;

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'name', obj: $this);
        Validations::notEmpty(attribute: 'email', obj: $this);

        Validations::uniqueness(fields: 'email', object: $this);

        if ($this->newRecord()) {
            Validations::passwordConfirmation($this);
        }
    }

    public function authenticate(string $password): bool
    {
        if ($this->password == null) {
            return false;
        }

        return password_verify(password: $password, hash: $this->password);
    }

    public static function findByEmail(string $email): Admin | null
    {
        return Admin::findBy(conditions: ['email' => $email]);
    }

    public function __set(string $property, mixed $value): void
    {
        parent::__set(property: $property, value: $value);

        if (
            $property === 'password' &&
            $this->newRecord() &&
            $value !== null && $value !== ''
        ) {
            $this->password = password_hash(password: $value, algo: PASSWORD_DEFAULT);
        }
    }

    // public function avatar(): ProfileAvatar
    // {
    //     return new ProfileAvatar($this);
    // }
}
