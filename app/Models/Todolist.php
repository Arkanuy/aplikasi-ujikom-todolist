<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    protected $guarded = [];

    public function tasks(){
        return $this->hasMany(Task::class, 'todolist_id');
    }
}
