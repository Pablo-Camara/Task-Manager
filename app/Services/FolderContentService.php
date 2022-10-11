<?php

namespace App\Services;

class FolderContentService
{

    /**
     *
     * @param FolderService $folderService
     */
    private $folderService;

    /**
     *
     * @param TaskService $folderService
     */
    private $taskService;



    public function __construct(
        TaskService $taskService,
        FolderService $folderService
    ) {
        $this->taskService = $taskService;
        $this->folderService = $folderService;
    }

    public function search($folderId = null) {
        $tasks = $this->taskService->search($folderId);
        $folders = $this->folderService->search($folderId);

        return [
            'tasks' => $tasks,
            'folders' => $folders
        ];
    }
}
