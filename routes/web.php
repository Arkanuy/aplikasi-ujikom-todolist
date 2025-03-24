<?php

use App\Livewire\Todolists\Index;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('todolists.index');
// });

Route::get('/', Index::class)->name("todolist");
Route::get('/todolist/{id}', \App\Livewire\Task\Index::class)->name("todolist-detail");
