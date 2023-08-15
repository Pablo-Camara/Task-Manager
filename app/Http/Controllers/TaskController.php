<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use App\Services\TaskService;
use App\Services\TaskTimeInteractionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function editName(Request $request) {
        Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:tasks,id',
                'name' => 'required|max:2048'
            ],
            [
                'name.required' => __('The task name cannot be empty'),
                'name.max' => __('The task name cannot have more than 2048 characters'),
            ]
        )->validate();

        /**
         * @var Task
         */
        $task = Task::find(
            $request->input('id')
        );

        $user = Auth::user();
        if ($task->user_id !== $user->id) {
            abort(403);
        }

        $task->name = $request->input('name');
        $taskSaved = $task->save();

        if ($taskSaved) {
            return new Response([
                'message' => __('Task name updated')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to save changes')
        ], 500);
    }


    public function setStatus(
        Request $request,
        TaskTimeInteractionService $taskTimeInteractionService
    ) {
        Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:tasks,id',
                'new_status_id' => 'required|exists:task_statuses,id'
            ]
        )->validate();

        /**
         * @var Task
         */
        $task = Task::find(
            $request->input('id')
        );

        $user = Auth::user();
        if ($task->user_id !== $user->id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $task->task_status_id = $request->input('new_status_id');
            $taskSaved = $task->save();

            $runningTimer = $taskTimeInteractionService->getRunningTimer($task->id);
            if (!empty($runningTimer)) {
                $runningTimer->endTimeInteraction();
            }

            DB::commit();
        } catch (\Throwable $th) {
            $taskSaved = false;
            DB::rollBack();
        }


        if ($taskSaved) {
            return new Response([
                'message' => __('Task status updated')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to save changes')
        ], 500);
    }

    public function createNew(Request $request, TaskService $taskService) {
        Validator::make(
            $request->all(),
            [
                'current-folder' => 'exists:folders,id',
            ]
        )->validate();

        $currentFolderId = $request->input('current-folder');

        $newTask = new Task();
        $newTask->name = 'New task';

        if (!empty($currentFolderId)) {
            $newTask->folder_id = $currentFolderId;
        }
        $user = Auth::user();
        $newTask->user_id = $user->id;
        $newTask->save();

        return new Response(
            $taskService->convertToListItemObj($newTask)
        );
    }


    public function changeParentFolder(Request $request) {

        $validationRules = [
            'id' => 'required|exists:tasks,id'
        ];

        if($request->input('new-parent-folder') !== 'null') {
            $validationRules = array_merge(
                $validationRules,
                [
                    'new-parent-folder' => 'required|exists:folders,id'
                ]
            );
        }

        Validator::make(
            $request->all(),
            $validationRules
        )->validate();

        /**
         * @var Task
         */
        $task = Task::find(
            $request->input('id')
        );

        $user = Auth::user();
        if ($task->user_id !== $user->id) {
            abort(403);
        }

        $newParentFolder = $request->input('new-parent-folder');

        if ($newParentFolder === 'null') {
            $newParentFolder = null;
        }

        if (!empty($newParentFolder)) {
            $newParentFolderInDb = Folder::find($newParentFolder);
            if ($newParentFolderInDb->user_id !== $user->id) {
                abort(403);
            }
        }

        $task->folder_id = $newParentFolder;
        $taskSaved = $task->save();

        if ($taskSaved) {
            return new Response([
                'message' => __('Task moved successfully')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to move task')
        ], 500);
    }
}
