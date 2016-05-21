<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function tasksList()
    {
        return $this->belongsTo('App\TasksList');
    }
}
