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
        // Define SEEDING constant to disable notifications
        if (!defined('SEEDING')) {
            define('SEEDING', true);
        }

        // Create Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@jumuiya.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '255700000000',
            ]
        );

        // Create Regular Admin
        User::firstOrCreate(
            ['email' => 'admin@jumuiya.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '255700000001',
            ]
        );

        // Create multiple Jumuiyas with chairpersons
        $jumuiyas = [
            ['name' => 'St. Peter', 'location' => 'Dar es Salaam', 'chairperson_name' => 'Peter Chair'],
            ['name' => 'St. Paul', 'location' => 'Mwanza', 'chairperson_name' => 'Paul Chair'],
            ['name' => 'St. Mary', 'location' => 'Arusha', 'chairperson_name' => 'Mary Chair'],
            ['name' => 'St. John', 'location' => 'Dodoma', 'chairperson_name' => 'John Chair'],
        ];

        foreach ($jumuiyas as $jumuiyaData) {
            // Create chairperson
            $chairperson = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $jumuiyaData['chairperson_name'])) . '@jumuiya.com'],
                [
                    'name' => $jumuiyaData['chairperson_name'],
                    'password' => Hash::make('password'),
                    'role' => 'chairperson',
                    'phone' => '255' . rand(700000000, 799999999),
                ]
            );

            // Create Jumuiya
            $jumuiya = Jumuiya::firstOrCreate(
                ['name' => $jumuiyaData['name']],
                [
                    'location' => $jumuiyaData['location'],
                    'description' => $jumuiyaData['name'] . ' Jumuiya',
                    'chairperson_id' => $chairperson->id,
                ]
            );

            // Create 5 members for each Jumuiya
            for ($i = 1; $i <= 5; $i++) {
                $memberName = $jumuiyaData['name'] . " Member " . $i;
                $member = User::firstOrCreate(
                    ['email' => strtolower(str_replace(' ', '', $memberName)) . '@jumuiya.com'],
                    [
                        'name' => $memberName,
                        'password' => Hash::make('password'),
                        'role' => 'member',
                        'phone' => '255' . rand(600000000, 699999999),
                    ]
                );

                // Associate member with Jumuiya
                $member->member()->firstOrCreate([
                    'user_id' => $member->id,
                    'jumuiya_id' => $jumuiya->id,
                    'joined_date' => now(),
                ]);
            }
        }
    }
}
