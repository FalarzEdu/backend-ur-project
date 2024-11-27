<?php

namespace Database\Populate;

use App\Models\Admin;
use Core\Database\ActiveRecord\Model;

class AdminsPopulate
{
    public static function populate()
    {
        $data =  [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $admin = new Admin($data);
        $admin->save();

        $numberOfAdmins = 2;

        for ($i = 1; $i < $numberOfAdmins; $i++) {
            $data =  [
                'name' => 'Admin' . $i,
                'email' => 'admin' . $i . '@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
            ];

            $admin = new Admin($data);
            $admin->save();
        }

        echo "Admins populated with $numberOfAdmins registers\n";
    }
}