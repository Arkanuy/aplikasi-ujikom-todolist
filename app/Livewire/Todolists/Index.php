<?php

namespace App\Livewire\Todolists;

use App\Models\Todolist;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false, $showEditModal = false, $showDeleteModal = false;
    public $todolists = [];

    public $todolist_id, $title, $due_date;

    public  $deleteTodolistId, $deleteTodolistTitle;


    public function mount()
    {

        $this->todolists = Todolist::all();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function openEditModal($id)
    {
        $this->showEditModal = true;
        $todolist = Todolist::find($id);

        if ($todolist) {
            $this->todolist_id = $id;
            $this->title = $todolist->title;
            $this->due_date = $todolist->due_date;
        }
    }


    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    public function update()
    {
        $todolist = Todolist::find($this->todolist_id);

        if ($todolist) {
            $todolist->title = $this->title;
            $todolist->due_date = $this->due_date;
            $todolist->save();

            $this->closeEditModal();
            $this->reset();
            $this->todolists = Todolist::all();
            session()->flash('message', 'Tugas berhasil diperbarui.');
        }
    }

    public function openDeleteModal($id)
    {
        $todolist = Todolist::find($id);
        if ($todolist) {
            $this->deleteTodolistId = $id;
            $this->deleteTodolistTitle = $todolist->title;
            $this->showDeleteModal = true;
        }
    }

    public function deleteTodolist()
    {
        $todolist = Todolist::find($this->deleteTodolistId);
        if ($todolist) {
            $todolist->delete();
            session()->flash('message', 'Tugas berhasil dihapus.');
        }
        $this->todolists = Todolist::all();
        $this->closeDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->reset(['deleteTodolistId', 'deleteTodolistTitle']);
    }

    public function redirectShow($id){
        $todolist_task = Todolist::find($id);

        return redirect()->route("todolist-detail", [$id => $todolist_task->id]);
    }


    public function save()
    {
        $todolist = Todolist::create([
            'title' => $this->title,
            'due_date' => $this->due_date,
            'status' => 'no_tasks'
        ]);
        $this->reset('title', 'due_date');
        $this->todolists = Todolist::all();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.todolists.index');
    }
}
