<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Todo;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = ['task1', 'task2', 'task3'];

        foreach ($tasks as $key => $task) {
            Todo::create([
                'id' => $key + 1,
                'task' => $task
            ]);
        }
    }
}
