<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ulid' => Str::ulid(),
            'title' => $this->faker->sentence,
            'init_board' => '-OOO----X-XO-O---XOOO-X-OOXOXX--OOOXXXX-OOXXXXX-O-XOOX---X-OO-X-', // Example initial board
            'kifu' => $this->faker->regexify('[A-H][1-8]{4}'), // Random moves
            'start_move' => $this->faker->numberBetween(1, 8),
            'black_user_name' => $this->faker->name,
            'white_user_name' => $this->faker->name,
            'begin_text' => $this->faker->paragraph,
            'end_text' => $this->faker->paragraph,
            'sort' => $this->faker->randomNumber(),
        ];
    }
}
