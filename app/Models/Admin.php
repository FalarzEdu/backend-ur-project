<?php

namespace App\Models;

use App\Services\ProfileAvatar;
use Core\Database\ActiveRecord\BelongsToMany;
use Core\Database\ActiveRecord\HasMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

// id' => 0,
//             'name' => 'Fulano',
//             'academic_register' => '0',
//             'email' => 'fulano@example.com',
//             'password' => '123456',
//             'phone' => '0',

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
    protected ?string $encrypted_password = null;

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::notEmpty('email', $this);

        Validations::uniqueness('email', $this);

        if ($this->newRecord()) {
            Validations::passwordConfirmation($this);
        }
    }

    public function authenticate(string $password): bool
    {
        if ($this->encrypted_password == null) {
            return false;
        }

        return password_verify($password, $this->encrypted_password);
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
            $this->encrypted_password = password_hash($value, PASSWORD_DEFAULT);
        }
    }

    // public function avatar(): ProfileAvatar
    // {
    //     return new ProfileAvatar($this);
    // }
}
