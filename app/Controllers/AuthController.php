<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Admin;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class AuthController
{
    private string $layout = 'login';

    public function new(): void
    {
        $this->render(view: 'new');
    }

    public function authenticate(Request $request): void
    {
        $params = $request->getParam(key: 'user');
        $searchUser = User::findByEmail(email: $params['email']);
        $searchAdmin = Admin::findByEmail(email: $params['email']);
        $user = $searchAdmin ?? $searchUser ?? null;

        if (is_a(object_or_class: $user, class: Admin::class)) {
            if ($user->authenticate(password: $params['password'])) {
                Auth::login(user: $user, role: 'admin');
              
                FlashMessage::success(value: 'Login realizado com sucesso!');
                $this->redirectTo(location: route(name: 'admins.home'));
            } else {
                FlashMessage::danger(value: 'Email e/ou senha inválidos!');
                $this->redirectTo(location: route(name: 'all.login'));
            }
        } elseif (is_a(object_or_class: $user, class: User::class)) {
            if ($user->authenticate(password: $params['password'])) {
                Auth::login(user: $user, role: 'user');

                FlashMessage::success(value: 'Login realizado com sucesso!');
                $this->redirectTo(location: route(name: 'users.home'));
            } else {
                FlashMessage::danger(value: 'Email e/ou senha inválidos!');
                $this->redirectTo(location: route(name: 'all.login'));
            }
        } else {
            FlashMessage::danger(value: 'Email e/ou senha inválidos!');
            $this->redirectTo(location: route(name: 'all.login'));
        }
    }

    public function destroy(): void
    {
        Auth::logout();
        FlashMessage::success(value: 'Logout realizado com sucesso!');
        $this->redirectTo(location: route(name: 'all.login'));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function render(string $view, array $data = []): void
    {
        extract(array: $data);

        $view = '/var/www/app/views/authentications/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }

    private function redirectTo(string $location): void
    {
        header(header: 'Location: ' . $location);
        exit;
    }
}
