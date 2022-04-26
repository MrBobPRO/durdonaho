<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Администратор', 'Простой Пользователь'];
        $email = ['admin@mail.ru', 'user@mail.ru'];
        $role = ['admin', 'user'];
        $verified = [1,0];

        for($i=0; $i<count($name); $i++) {
            $user = new User();
            $user->name = $name[$i];
            $user->email = $email[$i];
            $user->role = $role[$i];
            $user->verified_email = $verified[$i];
            $user->password = bcrypt('12345');
            $user->gender = 'male';
            $user->save();
        }
    }
}