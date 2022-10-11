<?php

namespace App\Services;

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

        if (empty($folderId)) {
            $tasks = $tasks->whereNull('folder_id');
        } else {
            $tasks = $tasks->where('folder_id', '=', $folderId);
        }

        $tasks = $tasks->get()->toArray();

        foreach ($tasks as $key => $task) {
            $tasks[$key]['parent_folders'] = $this->folderService->getParentFolders($task['folder_id']);
        }

        return $tasks;
    }
}
