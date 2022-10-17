<?php

namespace Database\Seeders;

use App\Helpers\Statuses\TaskStatuses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taskStatuses = (new ReflectionClass(TaskStatuses::class))->getConstants();

        foreach($taskStatuses as $key => $value) {
            DB::table('task_statuses')->insert([
                'id' => $value,
                'name' => $key
            ]);
        }
    }
}
