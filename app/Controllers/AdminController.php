<?php

namespace App\Controllers;

use App\Models\Admin;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

class AdminController {

  private string $layout = 'homeAdmin';

  public function index(): void 
  {
    $this->render('index');
  }

  /**
  * @param array<string, mixed> $data
  */
  private function render(string $view, array $data = []): void
  {
      extract($data);

      $view = '/var/www/app/views/home/admin/' . $view . '.phtml';
      require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
  }
}