<?php

namespace Tests\Unit\Models\Users;

use App\Models\Admin;
use Core\Debug\Debugger;
use Lib\Validations;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class AdminTest extends TestCase
{
    private Admin $user;
    private Admin $user2;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new Admin(params: [
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        ]);
        $this->user->save();

        $this->user2 = new Admin(params: [
        'name' => 'Admin1',
        'email' => 'admin1@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
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
        $testUser = new Admin(params: [
        'name' => 'Admin3',
        'email' => 'admin3@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        ]);

        $testUser->save();

        $this->assertIsObject(actual: $testUser);
    }

    public function test_find_by_email_should_return_user_from_db(): void
    {
        $user = $this->user->findByEmail(email: 'admin@example.com');

        $this->assertEquals(expected: $this->user->id, actual: $user->id);
    }
}
