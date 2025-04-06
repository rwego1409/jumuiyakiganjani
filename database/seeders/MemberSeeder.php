<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;  // Assuming each member is linked to a user

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example of creating a single member
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'), // Ensure the password is hashed
        ]);

        $user->member()->create([
            'jumuiya_id' => 1, // Example jumuiya_id, ensure this exists
            'phone' => '1234567890',  // Add any other member-specific fields
        ]);

        // You can add more members here
        Member::factory(10)->create(); // Assuming you have a Member Factory set up
    }
}
