<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TaskTimeInteraction extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;


    public function startTimeInteraction($startTime = null, bool $save = true) {
        if ($startTime === null) {
            $startTime = Carbon::now();
        }

        $this->started_at = $startTime->toDateTimeString();
        $this->started_at_day = $startTime->toDateString();

        if ($save) {
            $this->save();
        }
    }

    public function endTimeInteraction($endTime = null, bool $save = true) {
        if ($endTime === null) {
            $endTime = Carbon::now();
        }

        $this->ended_at = $endTime->toDateTimeString();
        $this->ended_at_day = $endTime->toDateString();

        $totalSecondsSpent = Carbon::parse($this->ended_at)
                                ->diffInSeconds(
                                    Carbon::parse($this->started_at)
                                );

        $totalHours = gmdate("H", $totalSecondsSpent);
        $totalMinutes = gmdate("i", $totalSecondsSpent);
        $totalSeconds = gmdate("s", $totalSecondsSpent);

        $this->hours = $totalHours;
        $this->minutes = $totalMinutes;
        $this->seconds = $totalSeconds;
        $this->total_seconds_spent = $totalSecondsSpent;

        if ($save) {
            $this->save();
        }
    }

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
