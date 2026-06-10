<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin', // Change to your preferred admin name
            'email' => 'admin@classifieds.com', // Change to your preferred admin email
            'password' => Hash::make('password'), // Change to a secure password
            'role' => 'admin', // Manually hardcoding the admin role here
        ]);
    }
}
