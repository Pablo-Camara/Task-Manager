<?php

namespace Database\Seeders;

use App\Helpers\Actions\TaskActions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class TaskActionsSeeder extends Seeder
{
    /**
     * Run the TaskActionsSeeder.
     *
     * @return void
     */
    public function run()
    {
        $taskActions = (new ReflectionClass(TaskActions::class))->getConstants();

        foreach($taskActions as $key => $value) {
            DB::table('task_actions')->insert([
                'id' => $value,
                'name' => $key
            ]);
        }
    }
}
