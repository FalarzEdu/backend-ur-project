<?php

namespace App\Middleware;

use Core\Http\Middleware\Middleware;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class Authenticate implements Middleware
{
    public function __construct(
        private string $roleRestriction
    ) {
    }

    public function handle(Request $request): void
    {

        if (!Auth::check()) {
            FlashMessage::danger(value: 'Você deve estar logado para acessar essa página');
            $this->redirectTo(location: route(name: 'all.login'));
            return;
        } else {
            if ($this->roleRestriction === 'all') {
                return;
            } elseif (
                !Auth::verifyRole(
                    roleRestriction: $this->roleRestriction
                )
            ) {
                FlashMessage::danger(value: 'Você deve estar logado para acessar essa página');
                $this->redirectTo(location: route(name: 'all.login'));
                return;
            }
        }
    }

    private function redirectTo(string $location): void
    {
        header(header: 'Location: ' . $location);
        exit;
    }
}
