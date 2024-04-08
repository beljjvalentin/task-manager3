<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'date' => $this->faker->date(),
            'category_id' => function () {
                // Get a random user_id from the User model
                return TaskCategory::inRandomOrder()->first()->id;
            },
            'user_id' => function () {
                // Get a random user_id from the User model
                return User::inRandomOrder()->first()->id;
            },
            'urgency' => $this->faker->numberBetween(1, 5),
        ];
    }

}
