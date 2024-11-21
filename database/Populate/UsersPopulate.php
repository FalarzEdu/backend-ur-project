<?php

namespace Database\Populate;

use App\Models\User;
use Core\Database\ActiveRecord\Model;

class UsersPopulate
{
    public static function populate()
    {
        $data =  [
            'id' => 0,
            'name' => 'Fulano',
            'academic_register' => '0',
            'email' => 'fulano@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phone' => '0',
        ];

        $user = new User($data);
        $user->save();

        $numberOfUsers = 10;

        for ($i = 1; $i < $numberOfUsers; $i++) {
            $data =  [
                'name' => 'Fulano ',
                'academic_register' => $i,
                'email' => 'fulano' . $i . '@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'phone' => $i
            ];

            $user = new User($data);
            $user->save();
        }

        echo "Users populated with $numberOfUsers registers\n";
    }
}