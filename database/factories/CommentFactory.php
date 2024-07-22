<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'moves' => $this->faker->numberBetween(1, 60),
            'text' => $this->faker->sentence,
        ];
    }
}
