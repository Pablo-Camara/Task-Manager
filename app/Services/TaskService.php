<?php

namespace App\Services;

use App\Helpers\Statuses\TaskStatuses;
use App\Models\Task;
use App\Models\TaskTimeInteraction;
use Illuminate\Support\Facades\DB;

class TaskService
{
    /**
     * @var FolderService
     */
    private $folderService;

    /**
     * @var TaskTimeInteractionService
     */
    private $taskTimeInteractionService;

    public function __construct(
        FolderService $folderService,
        TaskTimeInteractionService $taskTimeInteractionService
    ) {
        $this->folderService = $folderService;
        $this->taskTimeInteractionService = $taskTimeInteractionService;
    }

    /**
     * Gets all the tasks inside a folder
     * or all the top level tasks not inside a folder
     *
     * @param $folderId
     * @return array
     */
    public function search($folderId = null, $userId = null) {
        $tasks = Task::select(
            [
                'id',
                DB::raw('name AS title'),
                'folder_id'
            ]
        )
        ->with(
            [
                'tags' => function ($query) {
                    $query->select(['tags.id', 'tags.name']);
                }
            ]
        );

        if (!empty($userId)) {
            $tasks = $tasks->where('user_id', '=', $userId);
        }

        $tasks = $tasks->where('task_status_id', '=', TaskStatuses::ACTIVE);

        if (empty($folderId)) {
            $tasks = $tasks->whereNull('folder_id');
        } else {
            $tasks = $tasks->where('folder_id', '=', $folderId);
        }

        $tasks = $tasks->get();

        foreach ($tasks as $key => $task) {
            $tasks[$key] = $this->convertToListItemObj($task, false);
        }

        return $tasks->toArray();
    }


    public function convertToListItemObj(Task $task, bool $newTask = true) {
        $listItemObj = [
            'id' => $task->id,
            'title' => $task->name ?? $task->title,
            'tags' => $task->tags,
            'folder_id' => $task->folder_id,
            'parent_folders' => $this->folderService->getParentFolders($task->folder_id, $task->user_id)
        ];

        if ($newTask) {
            $listItemObj = array_merge(
                $listItemObj,
                [
                    'time_spent_today' => '00:00:00',
                    'is_timer_running' => false,
                ]
            );
        } else {
            $totalTimeSpentToday = $this->taskTimeInteractionService->getTotalTimeSpentToday($task->id);

            $runningTimer = $this->taskTimeInteractionService->getRunningTimer($task->id);
            $isTimerRunning = false;

            if (!empty($runningTimer)) {
                $isTimerRunning = true;
            }

            $listItemObj = array_merge(
                $listItemObj,
                [
                    'time_spent_today' => $totalTimeSpentToday,
                    'is_timer_running' => $isTimerRunning,
                ]
            );
        }

        return $listItemObj;
    }
}
