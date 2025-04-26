<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Jumuiya;
use App\Models\Member;
use App\Models\Contribution;
use App\Models\Event;
use App\Models\Resource;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Activity;

class AdminDashboardSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create Jumuiyas with locations and chairperson_id
        $jumuiyas = Jumuiya::factory()->count(5)->create([
            'name' => fn() => ['St. Peter', 'St. Paul', 'Holy Spirit', 'St. Mary', 'St. Joseph'][rand(0, 4)],
            'location' => $faker->address, // Corrected here, added a comma
            'chairperson_id' => fn() => User::inRandomOrder()->first()->id // Add chairperson_id
        ]);

        // Check if the admin user already exists
        $admin = User::firstOrCreate([
            'email' => 'admin@jumuiya.com'
        ], [
            'name' => 'Admin User',
            'role' => 'admin',
            'phone' => '255123456789',
            'password' => bcrypt('your-secure-password'), // Make sure to provide a password
        ]);

        // Create Members with Jumuiya associations
        $members = Member::factory()->count(50)->create([
            'jumuiya_id' => fn() => $jumuiyas->random()->id,
            'user_id' => fn() => User::factory()->create(['role' => 'member'])->id
        ]);

        // Create Contributions for members
Contribution::factory()->count(200)->create([
    'user_id' => fn() => $members->random()->user_id,
    'recorded_by' => $admin->id,
    'member_id' => fn() => $members->random()->id,
    'jumuiya_id' => fn() => $members->random()->jumuiya_id,
    'contribution_date' => Carbon::now()->subDays(rand(0, 90)),
]);
        // Create Events
        $events = Event::factory()->count(15)->create([
            'jumuiya_id' => fn() => $jumuiyas->random()->id,
            'status' => fn() => ['upcoming', 'ongoing', 'completed'][rand(0, 2)],
            'start_time' => Carbon::now()->addDays(rand(-10, 30))
        ]);

        // Create Resources
       // In your AdminDashboardSeeder
        Resource::factory()->count(25)->create();

        // Create Activity Logs
        $activities = [
            'created member',
            'updated contribution',
            'deleted event',
            'uploaded resource',
            'viewed dashboard'
        ];

        foreach (range(1, 100) as $i) {
            $loggableType = ['App\\Models\\Member', 'App\\Models\\Contribution', 'App\\Models\\Event'][rand(0, 2)];

            $activities = [
                'created member',
                'updated contribution',
                'deleted event',
                'uploaded resource',
                'viewed dashboard'
            ];
        
            foreach (range(1, 100) as $i) {
                $loggableType = ['App\\Models\\Member', 'App\\Models\\Contribution', 'App\\Models\\Event'][rand(0, 2)];
        
                Activity::create([
                    'user_id' => $admin->id, // Assuming $admin is already created in the seeder
                    'description' => $activities[rand(0, 4)], // Random description from the activities array
                    'activity_type' => $activities[rand(0, 4)], // Use the same activity description for the activity type
                    'loggable_type' => $loggableType, // This is the class name of the related model
                    'loggable_id' => $loggableType === 'App\\Models\\Member' ? $members->random()->id :
                                    ($loggableType === 'App\\Models\\Contribution' ? rand(1, 200) : rand(1, 15)),
                    'created_at' => Carbon::now()->subDays(rand(0, 30))
                ]);
            }
        }
    }
}
