<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tasks = ['ichiro', 'jiro', 'saburo', 'shiro', 'goro'];
        return [
            'task' => $tasks[rand(0, count($tasks) - 1)]
        ];
    }
}
