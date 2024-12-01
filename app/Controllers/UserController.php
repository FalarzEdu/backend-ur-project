<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

class UserController
{
    private string $layout = 'homeUser';

    public function index(): void
    {
        $this->render(view: 'index');
    }

  /**
  * @param array<string, mixed> $data
  */
    private function render(string $view, array $data = []): void
    {
        extract(array: $data);

        $view = '/var/www/app/views/home/user/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }
}
