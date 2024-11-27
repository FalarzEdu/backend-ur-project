<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

Class UserController {

  private string $layout = 'home';

  public function new(): void 
  {
    $this->render('new');
  }

  /**
  * @param array<string, mixed> $data
  */
  private function render(string $view, array $data = []): void
  {
      extract($data);

      $view = '/var/www/app/views/home-users/' . $view . '.phtml';
      require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
  }
}