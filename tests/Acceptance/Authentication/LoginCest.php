<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use Tests\Acceptance\BaseAcceptanceCest;
use Tests\Support\AcceptanceTester;

class LoginCest extends BaseAcceptanceCest
{
    public function loginSuccessful(AcceptanceTester $page): void
    {
        $user = new User(params: [
            'name' => 'Fulano',
            'academic_register' => '0',
            'email' => 'fulano@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phone' => '0',
        ]);

        $user->save();

        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'fulano@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');

        $page->see(text: 'Login realizado com sucesso!');
        $page->seeInCurrentUrl(uri: '/home');
    }

    public function loginUnsuccessful(AcceptanceTester $page): void
    {
        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'fulano@example.com');
        $page->fillField(field: 'user[password]', value: 'wrongPassword');

        $page->click(link: 'Entrar');

        $page->see(text: 'Email e/ou senha inválidos!');

        $page->seeInCurrentUrl(uri: '/login');
    }
}
