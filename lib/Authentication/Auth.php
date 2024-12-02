<?php

namespace Lib\Authentication;

use App\Models\Admin;
use App\Models\User;

class Auth
{
    public static function login(User | Admin $user, string $role): void
    {
        $_SESSION['user']['id'] = $user->id;
        $_SESSION['user']['role'] = $role;
    }

    public static function user(): Admin | User | null
    {
        if (isset($_SESSION['user']['id'])) {
            $role = $_SESSION['user']['role'];
            $id = $_SESSION['user']['id'];

            if ($role === 'admin') {
                return Admin::findById(id: $id);
            } elseif ($role === 'user') {
                return User::findById($id);
            }
        }

        return null;
    }

    public static function getRole(): ?string
    {
        if (isset($_SESSION['user']['role'])) {
            return $_SESSION['user']['role'];
        }

        return null;
    }

    public static function verifyRole(string $roleRestriction): bool
    {
        return Auth::getRole() === $roleRestriction;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']['id']) && self::user() !== null;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']['id']);
        unset($_SESSION['user']['role']);
    }
}
