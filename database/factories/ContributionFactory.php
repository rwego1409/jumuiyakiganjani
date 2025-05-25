<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContributionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => function (array $attributes) {
                return Member::find($attributes['member_id'])->user_id;
            },
            'member_id' => Member::factory(),
            'jumuiya_id' => function (array $attributes) {
                return Member::find($attributes['member_id'])->jumuiya_id;
            },
            'recorded_by' => User::where('role', 'admin')->inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(5000, 100000),
            'contribution_date' => function (array $attributes) {
                $jumuiya = Jumuiya::find($attributes['jumuiya_id']);
                return $this->faker->dateTimeBetween(
                    $jumuiya->created_at,
                    'now'
                );
            },
            'payment_method' => $this->faker->randomElement([
                'cash', 'palm_pesa', 'bank_transfer', 'mobile_money'
            ]),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'rejected']),
           'payment_reference' => fn() => (string) Str::uuid(),
// UUID generation
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'purpose' => $this->faker->sentence(),

        ];
    }
}