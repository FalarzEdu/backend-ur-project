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
            'password_confirmation' => '123456'
        ];

        $admin = new Admin($data);
        $admin->save();

        $numberOfadmins = 10;

        for ($i = 1; $i < $numberOfadmins; $i++) {
            $data =  [
                'name' => 'Admin ',
                'email' => 'admin' . $i . '@example.com',
                'password' => '123456',
                'password_confirmation' => '123456'
            ];

            $admin = new admin($data);
            $admin->save();
        }

        echo "Admins populated with $numberOfadmins registers\n";
    }
}