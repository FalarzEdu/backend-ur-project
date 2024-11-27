<?php
  namespace Tests\Unit\Models\Users;

  use App\Models\User;
  use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class UserTest extends TestCase
{
  private User $user;
  private User $user2;

  public function setUp(): void
  {
    parent::setUp();

    $this->user = new User([
        'name' => 'Fulano',
        'academic_register' => '0',
        'email' => 'fulano@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        'phone' => '0',
    ]);
    $this->user->save();

    $this->user2 = new User([
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
      $this->assertTrue($this->user->authenticate('123456'));
      $this->assertFalse($this->user->authenticate('wrong'));
  }

}