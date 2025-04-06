<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Jumuiya;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {    return [
        'user_id' => User::factory(),
        'jumuiya_id' => Jumuiya::factory(),
        'address' => $this->faker->address,
        'joined_date' => $this->faker->date(), // Add this line to ensure joined_date is populated
        'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
    ];
    }
}
