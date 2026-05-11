<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\IdeaHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IdeaHistory>
 */
class IdeaHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idea_id' => Idea::factory()->create(),
            'user_id' => User::factory()->create(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'links' => [fake()->url()],
            'changed_fields' => [
                'title' => [
                    'from' => fake()->sentence(),
                    'to' => fake()->sentence()
                ]
            ]
        ];
    }
}
