<?php

namespace App\Services;

use App\Helpers\Statuses\TaskStatuses;
use App\Models\Task;

class TaskService
{
    /**
     * @var FolderService
     */
    private $folderService;

    public function __construct(
        FolderService $folderService
    ) {
        $this->folderService = $folderService;
    }

    /**
     * Gets all the tasks inside a folder
     * or all the top level tasks not inside a folder
     *
     * @param $folderId
     * @return array
     */
    public function search($folderId = null) {
        $tasks = Task::select(
            [
                'id',
                'title',
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

        $tasks = $tasks->where('task_status_id', '=', TaskStatuses::ACTIVE);

        if (empty($folderId)) {
            $tasks = $tasks->whereNull('folder_id');
        } else {
            $tasks = $tasks->where('folder_id', '=', $folderId);
        }

        $tasks = $tasks->get()->toArray();

        foreach ($tasks as $key => $task) {
            $tasks[$key]['parent_folders'] = $this->folderService->getParentFolders($task['folder_id']);
            $tasks[$key]['time_spent_today'] = '00:00:00';
        }

        return $tasks;
    }
}
