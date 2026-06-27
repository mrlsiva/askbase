<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin account used to access the dashboard.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@askbase.test'],
            [
                'name' => 'AskBase Admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}
