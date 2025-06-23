<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Jumuiya;
use App\Models\Member;
use App\Models\Contribution;
use App\Models\Event;
use App\Models\Resource;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AdminDashboardSeeder extends Seeder
{
    public function run()
    {
        // Define SEEDING constant to disable notifications
        if (!defined('SEEDING')) {
            define('SEEDING', true);
        }

        $faker = Faker::create();

        // Create Jumuiyas
       // Remove explicit chairperson_id assignment
$jumuiyas = Jumuiya::factory()->count(5)->create();

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@jumuiya.com'
        ], [
            'name' => 'Admin User',
            'role' => 'admin',
            'phone' => '255' . $faker->numerify('#########'),
            'password' => bcrypt('securePassword123!'),
        ]);

        // Create members
        $members = Member::factory()->count(50)->create([
            'jumuiya_id' => fn() => $jumuiyas->random()->id,
            'user_id' => fn() => User::factory()->create([
                'role' => 'member',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')
            ])->id
        ]);

        // Create contributions
        Contribution::factory()->count(200)->create([
            'user_id' => fn() => $members->random()->user_id,
            'member_id' => fn() => $members->random()->id,
            'jumuiya_id' => fn() => $members->random()->jumuiya_id,
            'recorded_by' => $admin->id,
            'payment_method' => $faker->randomElement(['cash', 'palm_pesa', 'bank_transfer', 'mobile_money']),
            'status' => $faker->randomElement(['pending', 'confirmed', 'rejected']),
            'payment_reference' => fn() => (string) Str::uuid(),

            'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            'purpose' => $faker->sentence(),
            'amount' => $faker->numberBetween(1000, 100000),
            'contribution_date' => function() use ($faker, $jumuiyas) {
                $jumuiya = $jumuiyas->random();
                return $faker->dateTimeBetween(
                    $jumuiya->created_at,
                    'now'
                );
            
            }
        ]);

        // Create other entities
        Event::factory()->count(15)->create(); // Remove jumuiya_id from seeding
        Resource::factory()->count(25)->create();
        Activity::factory()->count(100)->create();
    }
}