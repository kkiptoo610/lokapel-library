<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'library@lokapelsenior.local',
            ],
            [
                'name' => 'Lokapel Senior',

                'email' => 'library@lokapelsenior.local',

                'password' => Hash::make('123456'),

                'is_active' => true,
            ]
        );
    }
}