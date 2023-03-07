<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
        $data = [];
        for ($i = 1; $i <= 10 ; $i++) {
            $data[] = [
                'id' => $i,
                'task' => Str::random(200)
            ];
        }
        Todo::insert($data);
        // ファクトリでテストデータ作成
        // Todo::factory(10)->create();
    }
}
