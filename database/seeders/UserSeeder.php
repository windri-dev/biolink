<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@biolink.local'],
            [
                'name' => 'Windri',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
