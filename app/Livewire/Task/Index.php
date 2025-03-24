<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Models\Todolist;
use Livewire\Component;

class Index extends Component
{
    public $todolist, $tasks;

    public $showAddTaskModal = false, $showDeleteTaskModal = false;
    public $description, $priority = "High";
    public $taskToDelete;

    public function mount($id)
    {
        $this->todolist = Todolist::with(['tasks' => function ($query) {
            $query->orderByRaw("FIELD(priority, 'High', 'Mid', 'Low')");
        }])->find($id);

        $this->tasks = $this->todolist->tasks;
    }

    public function openAddTaskModal()
    {
        $this->showAddTaskModal = true;
    }

    public function closeAddTaskModal()
    {
        $this->showAddTaskModal = false;
        $this->reset(['description', 'priority']);
    }

    public function addTask()
    {
        $this->validate([
            'description' => 'required|string|max:255',
            'priority' => 'required|in:High,Mid,Low',
        ]);

        $this->todolist->tasks()->create([
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => 'pending'
        ]);

        // Perbarui status todolist jika ada tugas
        if ($this->todolist->tasks()->count() > 0) {
            $this->todolist->status = 'incomplete';
            $this->todolist->save();
        }

        // Perbarui daftar tugas dengan urutan yang benar
        $this->tasks = $this->todolist->tasks()->orderByRaw("FIELD(priority, 'High', 'Mid', 'Low')")->get();

        session()->flash('message', 'Tugas berhasil ditambahkan.');
        $this->closeAddTaskModal();
    }

    public function updateStatus($taskId, $status)
    {
        $validStatuses = ['pending', 'in_progress', 'completed'];

        if (!in_array($status, $validStatuses)) {
            return;
        }

        $task = Task::find($taskId);
        if ($task) {
            $task->status = $status;
            $task->save();

            $this->updateTodolistStatus();
            $this->tasks = $this->todolist->tasks()->orderByRaw("FIELD(priority, 'High', 'Mid', 'Low')")->get();
        }
    }

    protected function updateTodolistStatus()
    {
        $totalTasks = $this->todolist->tasks()->count();
        $completedTasks = $this->todolist->tasks()->where('status', 'completed')->count();

        if ($completedTasks === $totalTasks && $totalTasks > 0) {
            $this->todolist->status = 'completed';
        } else {
            $this->todolist->status = 'incomplete';
        }

        $this->todolist->save();
    }

    public function updatePriority($taskId, $priority)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->priority = $priority;
            $task->save();
            $this->tasks = $this->todolist->tasks()->orderByRaw("FIELD(priority, 'High', 'Mid', 'Low')")->get();
        }
    }

    public function openDeleteTaskModal($taskId)
    {
        $this->showDeleteTaskModal = true;
        $this->taskToDelete = $taskId;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteTaskModal = false;
    }

    public function deleteTask()
    {
        $task = Task::find($this->taskToDelete);
        if ($task) {
            $task->delete();
        }

        $this->showDeleteTaskModal = false;
        $this->tasks = $this->todolist->tasks()->orderByRaw("FIELD(priority, 'High', 'Mid', 'Low')")->get();
    }



    public function render()
    {
        return view('livewire.task.index');
    }
}
