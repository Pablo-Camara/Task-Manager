<?php

namespace App\Services;

use App\Helpers\Statuses\TaskStatuses;
use App\Models\Task;
use App\Models\TaskTimeInteraction;
use Illuminate\Support\Facades\DB;

class TaskTimeInteractionService
{
    /**
     * @param $taskId
     * @return TaskTimeInteraction|null
     */
    public function getRunningTimer($taskId) {
        return TaskTimeInteraction::where('task_id', '=', $taskId)
            ->whereNull('ended_at_day')->first();
    }

}
