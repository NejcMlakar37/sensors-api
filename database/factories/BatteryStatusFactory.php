<?php

namespace Database\Factories;

use App\Models\BatteryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BatteryStatus>
 */
class BatteryStatusFactory extends Factory
{
    protected $model = BatteryStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomFloat(2, 0, 100),
            'created_at' => fake()->dateTimeBetween('-10 days', now()),
        ];
    }
}
