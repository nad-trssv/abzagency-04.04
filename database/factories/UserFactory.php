<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+380' . fake()->randomNumber(9, true),
            'position_id' => Position::count() > 0 ? Position::inRandomOrder()->first()->id : null,
            'photo' => fake()->imageUrl(640, 480, 'people', true),
        ];
    }
}
