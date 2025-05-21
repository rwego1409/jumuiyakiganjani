<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JumuiyaFactory extends Factory
{
    protected static $counter = 1;

    public function definition(): array
    {
        return [
            'name' => 'Jumuiya ' . static::$counter++ . ' - ' . Str::random(4),
            'location' => $this->faker->address,
            'chairperson_id' => User::where('role', 'admin')->exists()
                ? User::where('role', 'admin')->inRandomOrder()->first()->id
                : User::factory()->create(['role' => 'admin'])->id,
            'created_at' => $this->faker->dateTimeBetween('-2 years', '-1 month')
        ];
    }
}