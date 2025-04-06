<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@jumuiya.com'], // Check if user exists
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '255123456789',
            ]
        );

        // Chairperson user
        $chairperson = User::firstOrCreate(
            ['email' => 'chairperson@jumuiya.com'], // Check if user exists
            [
                'name' => 'Chairperson User',
                'password' => Hash::make('password'),
                'role' => 'chairperson',
                'phone' => '255987654321',
            ]
        );

        // Create Jumuiya first (if not exists)
        $jumuiya = Jumuiya::firstOrCreate(
            ['name' => 'St. Peter'],
            [
                'location' => 'Dar es Salaam',
                'description' => 'St. Peter Jumuiya',
                'chairperson_id' => $chairperson->id,
            ]
        );

        // Member user
        $member = User::firstOrCreate(
            ['email' => 'member@jumuiya.com'], // Check if user exists
            [
                'name' => 'Member User',
                'password' => Hash::make('password'),
                'role' => 'member',
                'phone' => '255789456123',
            ]
        );

        // Now create or associate the member with the Jumuiya
        $member->member()->firstOrCreate([
            'user_id' => $member->id,
            'jumuiya_id' => $jumuiya->id,
            'joined_date' => now(),
        ]);
    }
}
