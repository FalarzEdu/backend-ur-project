<?php

namespace App\Controllers;

use App\Models\Meal;
use Core\Http\Controllers\Controller;
use DateTime;

class AdminController extends Controller
{
    protected string $layout = 'admin';

    public function index(): void
    {
        $mealIds = Meal::getTodayMealsId();

        $todayLunch = Meal::findById(id: (int) $mealIds['lunchId']);
        $todayDinner = Meal::findById(id: (int) $mealIds['dinnerId']);

        $lunchReservations = $todayLunch->users()->count();
        $dinnerReservations = $todayDinner->users()->count();

        $this->render(view: 'index', data: compact('lunchReservations', 'dinnerReservations'));
    }

  /**
  * @param array<string, mixed> $data
  */
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/home/admin/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }
}
