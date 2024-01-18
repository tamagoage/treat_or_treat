<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Treat;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\treat>
 */
class TreatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Treat::class;

    public function definition(): array
    {

        $date = fake()->dateTimeBetween('-10 years', 'now');

        return [
            'user_id' => User::factory(),
            'location_id' => fake()->numberBetween(1, 10),
            'shelf_life_id' => fake()->numberBetween(1, 10),
            'image' => fake()->imageUrl(640, 480, 'food'),
            'name' => fake()->word(),
            'made_date' => fake()->dateTimeBetween('-1 years', 'now'),
            'pickup_deadline' => fake()->dateTimeBetween('now', '+1 years'),
            'url' => fake()->url(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
