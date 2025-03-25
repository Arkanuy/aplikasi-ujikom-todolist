<?php

use App\Http\Controllers\Api\Todolist as TodolistController;
use App\Http\Controllers\Api\Task as TaskController;
use Illuminate\Support\Facades\Route;

// Routes untuk Todolist
Route::get('todolists/index', [TodolistController::class, 'index'])->name('api.todolists.index');
Route::post('todolists/store', [TodolistController::class, 'store'])->name('api.todolists.store');
Route::delete('todolists/delete', [TodolistController::class, 'destroy'])->name('api.todolists.destroy');
Route::put('todolists/update', [TodolistController::class, 'update'])->name('api.todolists.update');

// Routes untuk Tasks
Route::get('tasks/index', [TaskController::class, 'index'])->name('api.tasks.index');
Route::post('tasks/store', [TaskController::class, 'store'])->name('api.tasks.store');
Route::delete('tasks/delete', [TaskController::class, 'destroy'])->name('api.tasks.destroy');
Route::put('tasks/update', [TaskController::class, 'update'])->name('api.tasks.update');
