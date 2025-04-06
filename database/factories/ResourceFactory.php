<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition()
    {
        return [
            'jumuiya_id' => \App\Models\Jumuiya::inRandomOrder()->first()->id,
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'file_path' => $this->faker->filePath(),
            'type' => $this->faker->randomElement(['bible', 'document', 'news']),
            'created_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
