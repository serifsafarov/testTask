<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->name = 'test';
        $user->password = \Illuminate\Support\Facades\Hash::make('123123123');
        $user->email = 'test@test.com';
        $user->save();
    }
}
