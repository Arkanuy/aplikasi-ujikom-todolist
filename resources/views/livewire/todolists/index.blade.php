<x-slot:title>Todolist</x-slot:title>

<div class="mx-4 md:mx-20 mt-6 ">
    <div
        class="flex justify-between items-center {{ $showModal || $showEditModal || $showDeleteModal ? 'opacity-50' : '' }}">
        <h2 class="text-2xl font-bold text-slate-800">Semua Daftar Tugas</h2>
        <button wire:click="openModal"
            class="text-white bg-[#7A73D1] hover:bg-[#5B53B3] text-lg font-semibold px-4 md:px-10 py-2 rounded-lg transition">
            +
        </button>
    </div>

    <div class="{{ $showModal || $showEditModal || $showDeleteModal ? 'opacity-50' : '' }}">
        @if ($todolists->isEmpty())
            <div class="mt-4 text-center">
                <p class="text-lg font-semibold text-gray-800">Belum ada daftar tugas</p>
            </div>
        @else
            <div class="mt-4">
                <div class="hidden md:block overflow-x-auto rounded-lg">
                    <table class="w-full min-w-[600px] border border-gray-300 bg-[#E3DAF7] text-gray-900 shadow-md">
                        <thead>
                            <tr class="bg-[#7A73D1] text-gray-100">
                                <th class="px-4 py-2 text-left rounded-tl-lg">Title</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Due Date</th>
                                <th class="px-4 py-2 text-center rounded-tr-lg">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todolists as $todolist)
                                <tr class="border-b border-gray-400 hover:bg-[#D8CFF1]">
                                    <td class="px-4 py-3">{{ $todolist->title }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-3 py-1 rounded-md text-sm font-medium
                                            {{ $todolist->status == 'completed' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }} capitalize">
                                            {{ $todolist->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $todolist->due_date }}</td>
                                    <td class="px-4 py-3 flex justify-center gap-2">
                                        <button wire:click="redirectShow({{ $todolist->id }})"
                                            class="px-3 py-1 text-sm text-white bg-green-600 hover:bg-green-700 rounded-md">
                                            View
                                        </button>
                                        <button wire:click="openEditModal({{ $todolist->id }})"
                                            class="px-3 py-1 text-sm text-white bg-[#4D55CC] hover:bg-[#3A42B3] rounded-md">
                                            Edit
                                        </button>
                                        <button wire:click="openDeleteModal({{ $todolist->id }})"
                                            class="px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="block md:hidden space-y-4">
                    @foreach ($todolists as $todolist)
                        <div class="p-4 bg-white rounded-lg shadow-md border border-gray-300">
                            <h5 class="text-lg font-semibold text-gray-900">{{ $todolist->title }}</h5>
                            <p class="text-sm text-gray-600">Status:
                                <span
                                    class="px-2 rounded-md text-sm font-medium
                                    {{ $todolist->status == 'Done' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                    {{ $todolist->status }}
                                </span>
                            </p>
                            <p class="text-sm text-gray-600">Batas Waktu: {{ $todolist->due_date }}</p>

                            <div class="mt-3 flex justify-between">
                                <button wire:click="redirectShow({{ $todolist->id }})"
                                    class="px-4 py-1 text-sm text-white bg-green-600 hover:bg-green-700 rounded-md">
                                    View
                                </button>
                                <button wire:click="openEditModal({{ $todolist->id }})"
                                    class="px-4 py-1 text-sm text-white bg-[#4D55CC] hover:bg-[#3A42B3] rounded-md">
                                    Edit
                                </button>
                                <button wire:click="openDeleteModal({{ $todolist->id }})"
                                    class="px-4 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>



    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl shadow-lg w-[90%] md:w-[400px]">
                <h3 class="text-xl font-bold mb-4 text-slate-800">Tambah Daftar Tugas</h3>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label for="title" class="block text-lg font-semibold">Judul</label>
                        <input type="text" wire:model="title" required
                            class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-[#211C84]">
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block text-lg font-semibold">Batas waktu</label>
                        <input type="date" wire:model="due_date" required
                            class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-[#211C84]">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-[#211C84] text-white rounded-lg hover:bg-[#7A73D1]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showEditModal)
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl shadow-lg w-[90%] md:w-[400px]">
                <h3 class="text-xl font-bold mb-4 text-slate-800">Edit Daftar Tugas</h3>

                <form wire:submit.prevent="update">


                    <div class="mb-4">
                        <label for="title" class="block text-lg font-semibold">Judul</label>
                        <input type="text" wire:model="title" value="{{ $todolist->title }}" required
                            class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-[#211C84]">
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block text-lg font-semibold">Batas waktu</label>
                        <input type="date" wire:model="due_date" value="{{ $todolist->due_date }}" required
                            class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-[#211C84]">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closeEditModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-[#211C84] text-white rounded-lg hover:bg-[#7A73D1]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showDeleteModal)
        <div class="fixed inset-0 flex items-center justify-center ">
            <div class="bg-white p-6 rounded-xl shadow-lg w-[90%] md:w-[400px]">
                <h3 class="text-xl font-bold mb-4 text-slate-800">Konfirmasi Hapus</h3>
                <p class="mb-4">Apakah Anda yakin ingin menghapus tugas
                    "<strong>{{ $deleteTodolistTitle }}</strong>"?</p>

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
