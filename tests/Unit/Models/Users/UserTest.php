<?php

namespace Tests\Unit\Models\Users;

use App\Models\User;
use Core\Debug\Debugger;
use Lib\Validations;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class UserTest extends TestCase
{
    private User $user;
    private User $user2;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User(params: [
        'name' => 'Fulano',
        'academic_register' => '0',
        'email' => 'fulano@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        'phone' => '0',
        ]);
        $this->user->save();

        $this->user2 = new User(params: [
        'name' => 'Fulano1',
        'academic_register' => '1',
        'email' => 'fulano1@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        'phone' => '1',
        ]);

        $this->user2->save();
    }

    public function test_authenticate_should_return_the_true(): void
    {
        $this->assertTrue(condition: $this->user->authenticate(password: '123456'));
        $this->assertFalse(condition: $this->user->authenticate(password: 'wrong'));
    }

    public function test_user_should_be_valid(): void
    {
        $errors = $this->user->allErrors();
        $this->assertEmpty(
            actual: $errors,
            message: 'Errors array should be empty when valid. Errors: ' . print_r(value: $errors)
        );
    }

    public function test_if_passwords_are_equal(): void
    {
        $this->assertTrue(condition: Validations::passwordConfirmation(obj: $this->user));
    }

    public function test_should_create_user(): void
    {
        $testUser = new User(params: [
        'name' => 'Fulano3',
        'academic_register' => '3',
        'email' => 'fulano1@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        'phone' => '3',
        ]);

        $testUser->save();

        $this->assertIsObject(actual: $testUser);
    }

    public function test_find_by_email_should_return_user_from_db(): void
    {
        $user = $this->user->findByEmail(email: 'fulano@example.com');

        $this->assertEquals(expected: $this->user->id, actual: $user->id);
    }
}
