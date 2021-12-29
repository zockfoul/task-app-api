<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->title(),
            'hex_color' => $this->faker->hexColor(),
            'author_id' => $this->getRandomUserId()
        ];
    }

    private function getRandomUserId(): int
    {
        return User::all()->random()->id;
    }
}