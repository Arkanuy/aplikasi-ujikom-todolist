<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todolist as ModelsTodolist;
use Illuminate\Http\Request;

class Todolist extends Controller
{
    public function index()
    {
        $todolist = ModelsTodolist::all()->map(function ($todolist) {
            return [
                'id' => $todolist->id,
                'title' => $todolist->title,
                'due_date' => $todolist->due_date,
                'status' => $todolist->status,
            ];
        });

        if (!$todolist) {
            return response()->json([
                'status' => false,
                'message' => 'Todolist not found!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Todolist found!',
            'data' => $todolist
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'due_date' => 'required|date'
        ], [
            'title.required' => 'Title is required!',
            'due_date.required' => 'Due date is required!',
        ]);

        $todolist = ModelsTodolist::where('title', $data['title'])->first();

        if ($todolist) {
            return response()->json([
                'status' => false,
                'message' => 'Todolist already exists!',
                'data' => []
            ], 400);
        }

        $todolist = ModelsTodolist::create([
            'title' => $data['title'],
            'due_date' => $data['due_date'],
            'status' => 'incomplete'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Todolist created!',
            'data' => [
                'id' => $todolist->id,
                'title' => $todolist->title,
                'due_date' => $todolist->due_date,
                'status' => $todolist->status,
            ]
        ], 200);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'title' => 'required|string',
            'due_date' => 'required|date'
        ]);

        $id = $data['id'];
        $todolist = ModelsTodolist::find($id);

        if (!$todolist) {
            return response()->json([
                'status' => false,
                'message' => 'Todolist not found!',
                'data' => []
            ], 404);
        }

        $todolist->title = $data['title'];
        $todolist->due_date = $data['due_date'];
        $todolist->save();

        return response()->json([
            'status' => true,
            'message' => 'Todolist updated!',
            'data' => [
                'id' => $todolist->id,
                'title' => $todolist->title,
                'due_date' => $todolist->due_date,
                'status' => $todolist->status,
            ]
        ], 200);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);
        $id = $data['id'];
        $todolist = ModelsTodolist::find($id);

        if (!$todolist) {
            return response()->json([
                'status' => false,
                'message' => 'Todolist not found!',
                'data' => []
            ], 404);
        }

        $todolist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Todolist deleted!',
            'data' => []
        ], 200);
    }
}
