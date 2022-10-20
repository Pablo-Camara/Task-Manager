<?php

namespace App\Services;

use App\Helpers\Statuses\TaskStatuses;
use App\Models\Task;
use App\Models\TaskTimeInteraction;
use Carbon\Carbon;
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

    public function getAllRunningTimers() {
        return TaskTimeInteraction::whereNull('ended_at_day')->get();
    }

    public function stopAllRunningTimers() {
        $runningTimers = $this->getAllRunningTimers();
        foreach ($runningTimers as $runningTimer) {
            $runningTimer->endTimeInteraction();
        }
    }

    public function getTotalTimeSpentToday($taskId) {
        $now = Carbon::now();

        $totalSecondsSpent = TaskTimeInteraction::where('task_id', '=', $taskId)
            ->where('ended_at_day', '=', $now->toDateString())
            ->sum('total_seconds_spent');

        $totalTimeSpentToday = gmdate("H:i:s", $totalSecondsSpent);

        return $totalTimeSpentToday;
    }
}
