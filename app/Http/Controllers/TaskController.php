<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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


    public function setStatus(Request $request) {
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

        $task->task_status_id = $request->input('new_status_id');
        $taskSaved = $task->save();

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

        $newTask->save();

        return new Response(
            $taskService->convertToListItemObj($newTask)
        );
    }
}
