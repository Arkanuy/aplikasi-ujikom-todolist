<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $priorityOptions = ["High", "Mid", "Low"];

    public function todolist(){
        return $this->belongsTo(Todolist::class);
    }

    public function getValidPriorities(){
        return $this->priorityOptions;
    }
}
