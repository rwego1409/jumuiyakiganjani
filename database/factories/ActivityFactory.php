<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->sentence,
            'activity_type' => $this->faker->randomElement([
                'created', 'updated', 'deleted', 'viewed', 'downloaded'
            ]),
            'loggable_type' => $this->faker->randomElement([
                'App\Models\Member', 'App\Models\Contribution', 'App\Models\Event'
            ]),
            'loggable_id' => $this->faker->numberBetween(1, 200),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now')
        ];
    }
}