<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement([
                Task::STATUS_BACKLOG,
                Task::STATUS_IN_PROGRESS,
                Task::STATUS_REVIEW,
                Task::STATUS_DONE
            ]),
            'priority' => $this->faker->randomElement([
                Task::PRIORITY_LOW,
                Task::PRIORITY_MEDIUM,
                Task::PRIORITY_HIGH,
                Task::PRIORITY_URGENT
            ]),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'assigned_to' => User::factory(),
            'created_by' => User::factory(),
            'labels' => $this->faker->randomElements(['Design', 'Development', 'Bug', 'Feature', 'Research'], 2),
            'position' => $this->faker->numberBetween(1, 100),
            'is_urgent' => $this->faker->boolean(10),
            'completed_at' => $this->faker->optional(0.3)->dateTime(),
        ];
    }
}
