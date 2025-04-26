<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContributionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'member')->inRandomOrder()->first()->id,
            'recorded_by' => User::where('role', 'admin')->inRandomOrder()->first()->id,
            'member_id' => Member::inRandomOrder()->first()->id,
            'jumuiya_id' => fn(array $attributes) => Member::find($attributes['member_id'])->jumuiya_id,
            'amount' => $this->faker->numberBetween(5000, 50000),
            'purpose' => $this->faker->randomElement(['Sunday Service', 'Building Fund', 'Harvest']),
            'contribution_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'payment_method' => $this->faker->randomElement(['cash', 'mobile', 'bank']),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'rejected']),
            'receipt_number' => 'RC-' . $this->faker->unique()->numberBetween(1000, 9999)
        ];
    }
}