<?php

namespace App\Http\Controllers;

use App\Services\TaskService;

class TaskController extends Controller
{

    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct(
        TaskService $taskService,
    ) {
        $this->taskService = $taskService;
    }

    public function list() {
        $tasks = $this->taskService->search();

        return $tasks;
    }
}
