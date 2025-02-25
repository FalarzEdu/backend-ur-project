<?php

namespace Tests\Acceptance\Snackbar;

use App\Models\Admin;
use App\Models\SnackbarGood;
use App\Models\User;
use Tests\Acceptance\BaseAcceptanceCest;
use Tests\Support\AcceptanceTester;

class SnackbarCest extends BaseAcceptanceCest
{
    protected User $user;
    protected Admin $admin;
    protected SnackbarGood $snack;

    public function _before(AcceptanceTester $page): void
    {
        parent::_before(page: $page);
        $this->user = new User([
            'name' => 'Fulano',
            'academic_register' => '0',
            'email' => 'fulano1@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phone' => '0',
        ]);
        $this->user->save();

        $this->admin = new Admin([
            'name' => 'Admin1',
            'email' => 'admin1@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);
        $this->admin->save();

        $this->snack = new SnackbarGood(params: [
            'price' => 15,
            'description' => 'Salgado de Frango'
        ]);
        $this->snack->save();
    }

    public function creatingSnackbarGoodSuccessfully(
        AcceptanceTester $page
    ): void {
        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'admin1@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');
        $page->seeInCurrentUrl(uri: '/dashboard');
        $page->reloadPage();

        $page->see(text: 'Cantina');
        $page->click(link: 'Cantina');
        $page->seeInCurrentUrl(uri: '/snackbar');

        $page->click('(//i[contains(@class, "fa-plus")])');
        $page->seeInCurrentUrl(uri: '/snackbar/create');

        $page->fillField(
            field: 'snackbar_good[description]',
            value: 'Salgado de Vina'
        );
        $page->fillField(
            field: 'snackbar_good[price]',
            value: 'R$ 15,00'
        );

        $page->click(link: 'Criar');
        $page->see(text: 'Item criado com sucesso!');
    }

    public function destroyingSnackbarGoodSuccessfully(
        AcceptanceTester $page
    ): void {
        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'admin1@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');
        $page->seeInCurrentUrl(uri: '/dashboard');
        $page->reloadPage();

        $page->see(text: 'Cantina');
        $page->click(link: 'Cantina');
        $page->seeInCurrentUrl(uri: '/snackbar');

        $page->click(link: '(//i[contains(@class, "fa-plus")])');
        $page->seeInCurrentUrl(uri: '/snackbar/create');

        $page->fillField(
            field: 'snackbar_good[description]',
            value: 'Salgado de Vina'
        );
        $page->fillField(
            field: 'snackbar_good[price]',
            value: 'R$ 15,00'
        );

        $page->click(link: 'Criar');
        $page->see(text: 'Item criado com sucesso!');

        $page->click(link: '(//i[contains(@class, "fa-trash-can")])');
        $page->see(text: 'Item removido com sucesso!');
    }

    public function updatingSnacksWithoutReloadingPage(
        AcceptanceTester $page
    ): void {
        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'fulano1@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');
        $page->seeInCurrentUrl(uri: '/home');
        $page->reloadPage();

        $page->see(text: 'Cantina');
        $page->click(link: 'Cantina');
        $page->seeInCurrentUrl(uri: '/snackbar');

        $page->see(text: 'Salgado de Frango');
        $page->see(text: 'R$ 15,00');

        $this->snack->update(data: [
            'price' => 17,
            'description' => 'Salgado de Frango'
        ]);
        $page->see(text: 'R$ 15,00');

        $page->click(link: '#refresh-data');
        $page->see(text: 'Salgado de Frango');
        $page->see(text: 'R$ 17,00');
    }
}
