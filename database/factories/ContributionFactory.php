<?php

namespace Database\Factories;
use App\Models\Member;  // Add this at the top of the file
use App\Models\Contribution;
use App\Models\Jumuiya;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contribution>
 */
class ContributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'jumuiya_id' => fn(array $attributes) => Member::find($attributes['member_id'])->jumuiya_id,
            'amount' => $this->faker->numberBetween(5000, 50000),
            'purpose' => $this->faker->randomElement(['Sunday Service', 'Building Fund', 'Harvest']),
            'contribution_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
