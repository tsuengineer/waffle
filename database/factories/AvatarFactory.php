<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvatarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'path' => $this->faker->imageUrl(640, 480, 'avatars', true),
        ];
    }
}
