<?php

namespace Tests\Acceptance\Reservations;

use App\Models\Admin;
use App\Models\BuffetReservation;
use App\Models\Meal;
use App\Models\User;
use Codeception\Util\Locator;
use DateTime;
use Tests\Acceptance\BaseAcceptanceCest;
use Tests\Support\AcceptanceTester;

class ReservationCest extends BaseAcceptanceCest
{
    private User $user;
    private User $user2;
    private Admin $admin;
    private Meal $lunch;
    private Meal $dinner;

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

        $this->user2 = new User([
            'name' => 'Fulano2',
            'academic_register' => '1',
            'email' => 'fulano2@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phone' => '1',
        ]);
        $this->user2->save();

        $this->admin = new Admin([
            'name' => 'Admin1',
            'email' => 'admin1@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);
        $this->admin->save();

        // $this->lunch = new Meal(params: [
        //     'date' => (new DateTime())->format(format: 'Y-m-d'),
        //     'meal_type' => 'lunch'
        // ]);
        // $this->lunch->save();
        // $this->dinner = new Meal(params: [
        //     'date' => (new DateTime())->format(format: 'Y-m-d'),
        //     'meal_type' => 'dinner'
        // ]);
        // $this->dinner->save();
    }

    public function shouldMakeLunchReservation(AcceptanceTester $page): void
    {
        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'fulano1@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');
        $page->seeInCurrentUrl(uri: '/home');
        $page->reloadPage();

        $page->click(link: 'Reservas');
        $page->see(text: 'Refeições');

        $page->click(link: 'Almoço');
        $page->see(text: 'Confirmação realizada com sucesso!');
    }

    public function adminShouldSeeReservations(AcceptanceTester $page): void
    {
        $mealsIds = Meal::getTodayMealsId();
        $reservation = new BuffetReservation(params: [
            'user_id' => $this->user->id,
            'meal_id' => $mealsIds['lunchId'],
            'has_assistance' => 0
        ]);
        $reservation->save();
        $reservation = new BuffetReservation(params: [
            'user_id' => $this->user2->id,
            'meal_id' => $mealsIds['lunchId'],
            'has_assistance' => 0
        ]);
        $reservation->save();
        $reservation = new BuffetReservation(params: [
            'user_id' => $this->user2->id,
            'meal_id' => $mealsIds['dinnerId'],
            'has_assistance' => 0
        ]);
        $reservation->save();

        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'admin1@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');
        $page->seeInCurrentUrl(uri: '/dashboard');
        $page->reloadPage();

        $page->see(text: 'Almoços confirmados');
        $page->see(text: '2');
    }

    public function userUnconffirmsMeal(AcceptanceTester $page): void
    {
        $page->amOnPage(page: '/login');

        $page->fillField(field: 'user[email]', value: 'fulano1@example.com');
        $page->fillField(field: 'user[password]', value: '123456');

        $page->click(link: 'Entrar');
        $page->seeInCurrentUrl(uri: '/home');
        $page->reloadPage();

        $page->click(link: 'Reservas');
        $page->see(text: 'Refeições');

        $page->click(link: 'Almoço');
        $page->see(text: 'Confirmação realizada com sucesso!');
        $page->reloadPage();

        $page->click(link: 'Almoço');
        $page->see(text: 'Sucesso ao desconfirmar presença.');
    }
}
