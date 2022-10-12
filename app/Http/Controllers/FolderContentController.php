<?php

namespace App\Http\Controllers;

use App\Services\FolderService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FolderContentController extends Controller
{

    /**
     * @var FolderService
     */
    private $folderService;

    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct(
        TaskService $taskService,
        FolderService $folderService,
    ) {
        $this->taskService = $taskService;
        $this->folderService = $folderService;
    }


    public function list (Request $request) {

        $selectedFolderId = $request->input('folder', null);

        $tasks = $this->taskService->search($selectedFolderId);
        $folders = $this->folderService->search($selectedFolderId);

        return new Response([
            'parent_folders' => $this->folderService->getParentFolders($selectedFolderId),
            'tasks' => $tasks,
            'folders' => $folders,
        ]);
    }
}
