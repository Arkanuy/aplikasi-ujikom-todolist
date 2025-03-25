<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task as ModelsTask;
use App\Models\Todolist;
use Illuminate\Http\Request;

class Task extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'todolist_id' => 'required'
        ]);

        $todolist_id = $request->todolist_id;
        $todolist = Todolist::find($todolist_id);

        if (!$todolist) {
            return response()->json([
                'status' => false,
                'message' => 'Todolist not found!',
                'data' => []
            ], 404);
        }

        $tasks = $todolist->tasks()->orderByRaw("FIELD(priority, 'High', 'Mid', 'Low')")->all()->map(function ($task) {
            return [
                'id' => $task->id,
                'description' => $task->description,
                'priority' => $task->priority,
                'status' => $task->status,
            ];
        });

        if (!$tasks) {
            return response()->json([
                'status' => false,
                'message' => 'Tasks not found!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tasks found!',
            'data' => $tasks
        ],200);
    }

    public function store(Request $request) {
        $request->validate([
            'todolist_id' => 'required',
            'description' => 'required|string|max:255',
            'priority' => 'required|in:High,Mid,Low',
        ]);

        $todolist_id = $request->todolist_id;
        $todolist = Todolist::find($todolist_id);

        if (!$todolist) {
            return response()->json([
                'status' => false,
                'message' => 'Todolist not found!',
                'data' => []
            ], 404);
        }

        $task = $todolist->tasks()->create([
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Task created!',
            'data' => [
                'id' => $task->id,
                'description' => $task->description,
                'priority' => $task->priority,
                'status' => $task->status,
            ]
        ],200);
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required',
            'description' => 'required|string|max:255',
            'priority' => 'required|in:High,Mid,Low',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $id = $request->id;
        $task = ModelsTask::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found!',
                'data' => []
            ], 404);
        }

        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->save();

        return response()->json([
            'status' => true,
            'message' => 'Task updated!',
            'data' => [
                'id' => $task->id,
                'description' => $task->description,
                'priority' => $task->priority,
                'status' => $task->status,
            ]
        ],200);
    }

    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        $id = $request->id;
        $task = ModelsTask::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found!',
                'data' => []
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Task deleted!',
            'data' => []
        ],200);
    }
}
