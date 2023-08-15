<?php

namespace App\Http\Controllers;

use App\Services\FolderService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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


    public function list(Request $request) {
        //@TODO: Fetch folders from logged in user only
        $selectedFolderId = $request->input('folder', null);
        $user = Auth::user();

        $tasks = $this->taskService->search($selectedFolderId, $user->id);
        $folders = $this->folderService->search($selectedFolderId, $user->id);

        return new Response([
            'current_folder_id' => $selectedFolderId,
            'parent_folders' => $this->folderService->getParentFolders($selectedFolderId, $user->id),
            'tasks' => $tasks,
            'folders' => $folders,
        ]);
    }


    public function listFolders(Request $request) {
        $selectedFolderId = $request->input('folder', null);
        $user = Auth::user();
        $folders = $this->folderService->search($selectedFolderId, $user->id);

        return new Response([
            'parent_folders' => $this->folderService->getParentFolders($selectedFolderId, $user->id),
            'folders' => $folders,
        ]);
    }

}
