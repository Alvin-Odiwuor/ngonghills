<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $openingHour = fake()->numberBetween(6, 12);
        $closingHour = fake()->numberBetween(max($openingHour + 1, 13), 23);

        return [
            'name' => fake()->unique()->company() . ' Outlet',
            'type' => fake()->randomElement(['restaurant', 'bar', 'spa', 'room_service', 'shop', 'events', 'other']),
            'location' => fake()->randomElement(['Ground Floor', 'First Floor', 'Second Floor', 'Rooftop', 'Poolside']),
            'manager_id' => User::query()->inRandomOrder()->value('id') ?? User::factory()->create()->id,
            'phone_extension' => (string) fake()->numberBetween(100, 9999),
            'opening_time' => sprintf('%02d:00', $openingHour),
            'closing_time' => sprintf('%02d:00', $closingHour),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
