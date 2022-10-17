<?php

namespace App\Http\Controllers;

use App\Models\Task;
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

        if (empty($task)) {
            throw ValidationException::withMessages([
                'id' => __('Task not found')
            ]);
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
}
