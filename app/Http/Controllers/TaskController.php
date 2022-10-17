<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function editTitle(Request $request) {
        Validator::make(
            $request->all(),
            [
                'task_id' => 'required|exists:tasks,id',
                'title' => 'required|max:2048'
            ],
            [
                'title.required' => __('The task title cannot be empty'),
                'title.max' => __('The task title cannot have more than 2048 characters'),
            ]
        )->validate();

        /**
         * @var Task
         */
        $task = Task::find(
            $request->input('task_id')
        );

        if (empty($task)) {
            throw ValidationException::withMessages([
                'task_id' => __('Task not found')
            ]);
        }

        $task->title = $request->input('title');
        $taskSaved = $task->save();

        if ($taskSaved) {
            return new Response([
                'message' => __('Task title updated')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to save changes')
        ], 500);
    }
}
