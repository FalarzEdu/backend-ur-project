<?php

namespace App\Controllers;

use App\Models\Meal;
use Core\Http\Controllers\Controller;

class UserController extends Controller
{
    protected string $layout = 'user';

    public function index(): void
    {
        $this->render(view: 'index');
    }

  /**
  * @param array<string, mixed> $data
  */
    protected function render(string $view, array $data = []): void
    {
        extract(array: $data);

        $view = '/var/www/app/views/home/user/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }
}
