<?php

namespace Database\Factories;
use App\Models\Member;  // Add this at the top of the file
use App\Models\Event;
use App\Models\Jumuiya;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'location' => $this->faker->address,
            'start_time' => $this->faker->dateTimeBetween('now', '+2 months'),
            'end_time' => fn(array $attributes) => Carbon::parse($attributes['start_time'])->addHours(2),
            'status' => 'upcoming',
        ];
    }
}

