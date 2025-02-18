<?php
declare(strict_types=1);

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ExampleCest
{
    public function tryExample(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email');
    }
}