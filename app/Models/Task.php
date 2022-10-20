<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * Get all the tags associated to a task
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'task_tags'
        );
    }

     /**
     * Get the folder that a task belongs to
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function timeInteractions() {
        return $this->belongsToMany(
            TaskTimeInteraction::class,
            'task_time_intereactions'
        );
    }
}
