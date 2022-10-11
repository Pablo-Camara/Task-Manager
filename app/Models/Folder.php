<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{

    /**
     * Get all the tags associated to a folder
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'folder_tags'
        );
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
