<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = env("APP_USERNAME");
        $pass = env("APP_PASSWORD");
        User::create([
            'name' => 'Admin',
            'username' => $username,
            'password' => Hash::make($pass),
        ]);
    }
}
