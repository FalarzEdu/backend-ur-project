<?php

namespace Tests\Acceptance\FeedbackImage;

use App\Models\User;
use Tests\Acceptance\BaseAcceptanceCest;
use Tests\Support\AcceptanceTester;

class FeedbackImageCest extends BaseAcceptanceCest
{
    public function uploadImageWithFeedback(AcceptanceTester $page): void
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

        $page->amOnPage('/feedbacks/create');
        $page->selectOption('select[id=feedback-type-select]', 'Pergunta');
        $page->fillField('message[content]', 'conntent');
        $page->attachFile('input[type=file]', 'test.jpg');
        $page->click('Criar');

        $page->see('Feedback created successfully!');
        $page->reloadPage();

        $page->waitForElementVisible('.fa-eye', 5);

        $page->click('(//i[contains(@class, "fa-eye")])[last()]');

        $page->waitForElement('img', 5);
        $page->seeElement('img');
    }
}
