<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Database\Seeder;

class JumuiyaSeeder extends Seeder
{
    // database/seeders/JumuiyaSeeder.php
public function run()
{
    // Get or create a chairperson user
    $chairperson = User::firstOrCreate(
        ['email' => 'chairperson@example.com'],
        [
            'name' => 'Chairperson User',
            'password' => bcrypt('password'),
            'role' => 'chairperson',
            'phone' => '255123456789'
        ]
    );

    $jumuiyas = [
        [
            'name' => 'St. Peter', 
            'location' => 'Dar es Salaam',
            'description' => 'St. Peter Jumuiya',
            'chairperson_id' => $chairperson->id
        ],
        // Add other jumuiyas
    ];

    foreach ($jumuiyas as $jumuiya) {
        Jumuiya::create($jumuiya);
    }
}
}