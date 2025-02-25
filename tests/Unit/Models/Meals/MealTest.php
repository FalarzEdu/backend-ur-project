<?php

namespace Tests\Unit\Models;

use App\Models\BuffetReservation;
use App\Models\Meal;
use App\Models\User;
use DateTime;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class MealTest extends TestCase
{
    private Meal $lunch;
    private User $user1;
    private User $user2;
    private User $user3;

    public function setUp(): void
    {
        // Setting up meals --------------------------------------------
        parent::setUp();

        $lunchData = [
            'date' => (new DateTime())->format('Y-m-d'),
            'meal_type' => 'lunch'
        ];

        $this->lunch = new Meal(params: $lunchData);

        // Setting up users ---------------------------------------------
        for ($i = 1; $i <= 3; $i++) {
            $user = "user$i";

            $this->$user = new User(params: [
                'name' => "Fulano $i",
                'academic_register' => (string) $i,
                'email' => "Fulano$i@example.com",
                'password' => '123456',
                'password_confirmation' => '123456',
                'phone' => (string) $i,
            ]);
            $this->$user->save();
        }
    }

    public function testShouldCreateMeal(): void
    {
        // Should insert the first row on the table
        $this->assertTrue(condition: $this->lunch->save());
        $this->assertCount(expectedCount: 1, haystack: Meal::all());
    }

    public function testShouldNotCreateMeal(): void
    {
        $data = [
            'date' => (new DateTime())->format('Y-m-d'),
            'meal_type' => ''
        ];
        $meal = new Meal(params: $data);

        assertTrue(condition: $meal->hasErrors());
        assertFalse(condition: $meal->save());
    }

    public function testShouldReturnTodayMealsIds(): void
    {
        $data = [
            'date' => (new DateTime())->format('Y-m-d'),
            'meal_type' => 'lunch'
        ];
        $lunch = new Meal(params: $data);

        $data = [
            'date' => (new DateTime())->format('Y-m-d'),
            'meal_type' => 'dinner'
        ];
        $dinner = new Meal(params: $data);

        $lunch->save();
        $dinner->save();

        // Shoul be an array of today's meals id's
        $mealIds = Meal::getTodayMealsId();

        $this->assertIsArray(actual: $mealIds);
        $this->assertArrayHasKey(key: 'lunchId', array: $mealIds);
        $this->assertArrayHasKey(key: 'dinnerId', array: $mealIds);
        // Verify if id's are correct
        $this->assertEquals(
            expected: $lunch->id,
            actual: (int) $mealIds['lunchId']
        );
        $this->assertEquals(
            expected: $dinner->id,
            actual: (int) $mealIds['dinnerId']
        );
    }

    public function testShouldReturnNumberOfUsersForASpecificMeal(): void
    {
        $lunch = new Meal(params: [
            'date' => (new DateTime())->format(format: 'Y-m-d'),
            'meal_type' => 'lunch'
        ]);
        $lunch->save();

        $dinner = new Meal(params: [
            'date' => (new DateTime())->format(format: 'Y-m-d'),
            'meal_type' => 'dinner'
        ]);
        $dinner->save();

        // Makes two reservations for two users for lunch
        for ($i = 1; $i <= 2; $i++) {
            $user = "user$i";
            $reservation = new BuffetReservation(params: [
                'user_id' => $this->$user->id,
                'meal_id' => $lunch->id,
                'has_assistance' => 0
            ]);
            $reservation->save();
        }

        // Makes one reservation for dinner
        $reservation = new BuffetReservation(params: [
            'user_id' => $this->user3->id,
            'meal_id' => $dinner->id,
            'has_assistance' => 0
        ]);
        $reservation->save();

        // Verifies if lunch actually has 2 reservations
        $this->assertEquals(expected: 2, actual: $lunch->users()->count());

        // Verifies if dinner actually has 1 reservation
        $this->assertEquals(expected: 1, actual: $dinner->users()->count());
    }
}
