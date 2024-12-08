<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = [
            ['status' => null],
            ['status' => 'in_work'],// 'taked_user_id' => rand(1, 10) ],
            ['status' => 'completed'],// 'taked_user_id' => rand(1, 10) ]];
        ];
        $ststus = $statuses[array_rand($statuses)];
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'start' => now()->subDays(rand(1, 30)),
            'end' => now()->addMonths(1)->addDays(rand(1, 30)),
            'user_id' => rand(1, 10),
            'status' => $ststus['status'],
            'public' =>true,
        ];
    }
}
