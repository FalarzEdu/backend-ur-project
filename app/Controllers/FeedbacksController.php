<?php

namespace App\Controllers;

use Core\Http\Controllers\Controller;
use Lib\Authentication\Auth;
use Core\Constants\Constants;
use Core\Http\Request;
use Lib\FlashMessage;

class FeedbacksController extends Controller
{
    protected string $layout;
    private string $role;

    public function __construct()
    {
        $this->layout = Auth::getRole();
        $this->role = Auth::getRole();
    }

    public function index(): void
    {
        $this->render(view: 'index');
    }

    protected function render(string $view, array $data = []): void
    {
        extract(array: $data);

        $view = Constants::rootPath()->join(
            path: "app/views/feedbacks/$this->role/$view.phtml"
        );
        require Constants::rootPath()->join(
            path: "app/views/layouts/$this->layout.phtml"
        );
    }

}
