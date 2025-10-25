<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'Username' => 'admin01',
                'Fname' => 'Admin',
                'Lname' => 'Bookstore',
                'Email' => 'admin@example.com',
                'Password' => Hash::make('password'),
            ],
            [
                'Username' => 'reader01',
                'Fname' => 'John',
                'Lname' => 'Reader',
                'Email' => 'reader@example.com',
                'Password' => Hash::make('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['Email' => $user['Email']], $user);
        }
    }
}
