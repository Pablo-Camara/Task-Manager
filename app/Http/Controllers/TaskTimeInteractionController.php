<?php

namespace App\Http\Controllers;

use App\Models\TaskTimeInteraction;
use App\Services\TaskService;
use App\Services\TaskTimeInteractionService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskTimeInteractionController extends Controller
{

    public function startTimeInteraction(
        Request $request,
        TaskTimeInteractionService $taskTimeInteractionService
    ) {
        Validator::make(
            $request->all(),
            [
                'task_id' => 'required|exists:tasks,id',
            ]
        )->validate();

        $taskId = $request->input('task_id');

        if (!empty($taskTimeInteractionService->getRunningTimer($taskId))) {
            //TODO: translate
            throw ValidationException::withMessages([
                'time_interaction' => 'You have already started the timer for this task.'
            ]);
        }

        $taskTimeInteractionService->stopAllRunningTimers();

        $newTimeInteraction = new TaskTimeInteraction();
        $newTimeInteraction->task_id = $taskId;
        $newTimeInteraction->startTimeInteraction();

        return new Response([
            'time_interaction' => 'Started the timer.'
        ], Response::HTTP_CREATED);
    }

    public function endTimeInteraction(
        Request $request,
        TaskTimeInteractionService $taskTimeInteractionService
    ) {
        Validator::make(
            $request->all(),
            [
                'task_id' => 'required|exists:tasks,id',
            ]
        )->validate();

        $taskId = $request->input('task_id');

        $unEndedTimeInteraction = $taskTimeInteractionService->getRunningTimer($taskId);

        if (empty($unEndedTimeInteraction)) {
             //TODO: translate
             throw ValidationException::withMessages([
                'time_interaction' => 'Cannot stop the timer because it has never been started.'
            ]);
        }

        $startedAt = Carbon::parse($unEndedTimeInteraction->started_at);
        $now = Carbon::now();

        // if timer ended the same day
        // lets just close the time interaction row by setting the ended_at date/time
        // and calculating total amount of hours/minutes/seconds spent.
        if ($startedAt->toDateString() === $now->toDateString()) {
            $unEndedTimeInteraction->endTimeInteraction();
            return $this->timerStoppedResponse();
        }

        // if it is not the same day
        // then lets first: close the time interaction row for the start day
        $endedAt = $startedAt->clone()->endOfDay();
        $unEndedTimeInteraction->endTimeInteraction($endedAt);

        // and then add a time interaction row for all of the following days
        $period = CarbonPeriod::create(
            $startedAt->addDay(1)->toDateString(),
            $now->toDateString()
        );

        foreach($period as $date) {
            $timeInteractionForDate = new TaskTimeInteraction();
            $timeInteractionForDate->task_id = $taskId;
            $timeInteractionForDate->startTimeInteraction($date->startOfDay(), false);

            if ($date->toDateString() !== $now->toDateString()) {
                // if not yet todays date, use the date/time of the end of the day
                $timeInteractionForDate->endTimeInteraction($date->endOfDay());
            } else {
                // if it is todays date, then use current date/time
                $timeInteractionForDate->endTimeInteraction($now);
            }
        }

        return $this->timerStoppedResponse();
    }

    public function runningTasks(
        Request $request,
        TaskTimeInteractionService $taskTimeInteractionService,
        TaskService $taskService
    ) {
        $result = [];

        $runningTimers = $taskTimeInteractionService->getAllRunningTimers();
        foreach($runningTimers as $runningTimer) {
            $result[] = $taskService->convertToListItemObj($runningTimer->task, false);
        }

        return $result;
    }

    private function timerStoppedResponse () {
        return new Response([
            'time_interaction' => 'Stopped the timer.'
        ], Response::HTTP_OK);
    }
}
