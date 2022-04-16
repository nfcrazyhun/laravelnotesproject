<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'body' => $this->faker->sentence(),
            'is_private' => false,
        ];
    }

    /**
     * Indicate that the model's status should be private.
     *
     * @return static
     */
    public function private()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_private' => true,
            ];
        });
    }
}
