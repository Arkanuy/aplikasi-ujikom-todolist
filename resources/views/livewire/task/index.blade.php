<x-slot:title>Taks</x-slot:title>
<div class="mx-4 md:mx-20 mt-6">
    <h1 class="text-xl md:text-2xl font-bold text-slate-800 {{ $showAddTaskModal || $showDeleteTaskModal ? 'opacity-50' : '' }}">
        Batas waktu: <span class="text-yellow-600">{{ $todolist->due_date }}</span>
    </h1>

    <div class="flex justify-between items-center {{ $showAddTaskModal || $showDeleteTaskModal ? 'opacity-50' : '' }}">
        <h4 class="text-xl md:text-2xl font-bold text-slate-800">{{ $todolist->title }} - Tugas</h4>
        <button wire:click="openAddTaskModal"
            class="text-white bg-[#7A73D1] hover:bg-[#5B53B3] text-lg font-semibold px-4 md:px-10 py-2 rounded-lg transition">
            +
        </button>
    </div>

    <div class="">
        @if ($tasks->isEmpty())
            <div class="mt-4 text-center">
                <p class="text-lg font-semibold text-gray-800">Belum ada tugas</p>
            </div>
        @else
            <div class="hidden md:block mt-4 overflow-x-auto rounded-lg">
                <table class="w-full min-w-[600px] border border-gray-300 bg-[#E3DAF7] text-gray-900 shadow-md {{ $showAddTaskModal || $showDeleteTaskModal ? 'opacity-50' : '' }}">
                    <thead>
                        <tr class="bg-[#7A73D1] text-gray-100">
                            <th class="px-4 py-2 text-left rounded-tl-lg">Deskripsi</th>
                            <th class="px-4 py-2 text-left">Prioritas</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-center rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="border-b border-gray-400 hover:bg-[#D8CFF1]">
                                <td class="px-4 py-3">{{ $task->description }}</td>
                                <td class="px-4 py-3">
                                    <select wire:change="updatePriority({{ $task->id }}, $event.target.value)"
                                        class="px-3 py-1 rounded-md text-sm font-medium
                                        {{ $task->priority == 'High' ? 'bg-red-500 text-white' : ($task->priority == 'Mid' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                        <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                        <option value="Mid" {{ $task->priority == 'Mid' ? 'selected' : '' }}>Mid</option>
                                        <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                    </select>
                                </td>
                                <td>
                                    <select wire:change="updateStatus({{ $task->id }}, $event.target.value)"
                                        class="px-3 py-1 text-sm rounded-md text-white
                                        {{ $task->status == 'pending' ? 'bg-yellow-500' :
                                           ($task->status == 'in_progress' ? 'bg-blue-500' : 'bg-green-500') }}">
                                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3 flex justify-center gap-2">
                                    <button wire:click="openDeleteTaskModal({{ $task->id }})"
                                        class="px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden mt-4 space-y-4">
                @foreach ($tasks as $task)
                    <div class="bg-[#E3DAF7] border border-gray-300 p-4 rounded-lg shadow-md">
                        <p class="text-gray-900 font-semibold">{{ $task->description }}</p>

                        <div class="mt-2 space-y-2">
                            <div>
                                <label class="block text-sm font-medium">Prioritas</label>
                                <select wire:change="updatePriority({{ $task->id }}, $event.target.value)"
                                    class="w-full mt-1 px-3 py-1 rounded-md text-sm font-medium
                                    {{ $task->priority == 'High' ? 'bg-red-500 text-white' : ($task->priority == 'Mid' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                    <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Mid" {{ $task->priority == 'Mid' ? 'selected' : '' }}>Mid</option>
                                    <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Status</label>
                                <select wire:change="updateStatus({{ $task->id }}, $event.target.value)"
                                    class="w-full mt-1 px-3 py-1 text-sm rounded-md border border-gray-300 bg-white text-gray-800 {{ $task->status == 'pending' ? 'bg-yellow-500' :
                                       ($task->status == 'in_progress' ? 'bg-blue-500' : 'bg-green-500') }}">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 flex justify-end">
                            <button wire:click="openDeleteTaskModal({{ $task->id }})"
                                class="px-4 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($showDeleteTaskModal)
        <div class="fixed inset-0 flex items-center justify-center ">
            <div class="bg-white p-6 rounded-xl shadow-lg w-[90%] md:w-[400px]">
                <h3 class="text-xl font-bold mb-4 text-slate-800">Konfirmasi Hapus</h3>
                <p class="mb-4">Apakah Anda yakin ingin menghapus tugas ini?</p>

                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="closeDeleteModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                    <button type="button" wire:click="deleteTodolist"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if ($showAddTaskModal)
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl shadow-lg w-[90%] md:w-[400px]">
                <h3 class="text-xl font-bold mb-4 text-slate-800">Tambah Tugas</h3>

                <form wire:submit.prevent="addTask">
                    <div class="mb-4">
                        <label class="block text-lg font-semibold">Deskripsi tugas</label>
                        <input type="text" wire:model="description" required
                            class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-[#211C84]">
                    </div>

                    <div class="mb-4">
                        <label class="block text-lg font-semibold">Prioritas</label>
                        <select wire:model="priority" required
                            class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-[#211C84] bg-white">
                            <option value="High">Tinggi</option>
                            <option value="Mid">Sedang</option>
                            <option value="Low">Rendah</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closeAddTaskModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-[#211C84] text-white rounded-lg hover:bg-[#7A73D1]">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
