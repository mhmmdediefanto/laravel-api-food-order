<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('12345'),
                'role_id' => 3
            ],
            [
                'name' => 'Waitress',
                'email' => 'waitress@gmail.com',
                'password' => Hash::make('12345'),
                'role_id' => 1
            ],
            [
                'name' => 'Chef',
                'email' => 'chef@gmail.com',
                'password' => Hash::make('12345'),
                'role_id' => 2
            ], [
                'name' => 'Chasier',
                'email' => 'chasier@gmail.com',
                'password' => Hash::make('12345'),
                'role_id' => 4
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
