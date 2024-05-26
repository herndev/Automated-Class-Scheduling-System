<x-app-layout>
    <x-slot name="header">
        {{ __('Rooms') }}
    </x-slot>
    @if (session()->has('success'))
        <div class="alert alert-success">
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">{{ session()->get('success') }}</span>
                </div>
            </div>
        </div>
    @endif
    <div class="flex">
        <div class="w-2/5">
            <div class="bg-gray-800 p-4 rounded-lg h-500">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <p class="text-white text-2xl">Room Form</p>
                    <div class="mt-10 mb-5">
                        <p class="text-white">Room:</p>
                        <input type="text" name="name" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-5">
                        <label for="description" style="color:white;">Description</label>
                        <select name="description" id="description" class="rounded w-full">
                            <option>
                                Select
                            </option>
                            <option value="lab">
                                Lab
                            </option>
                            <option value="lecture">
                                Lecture
                            </option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 w-1/5">Save</button>
                        <button type="reset"
                            class="px-4 py-2 rounded-md w-1/5 text-white hover:bg-red-800">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-3/5 ml-4">
            <div class="bg-gray-800 p-4 rounded-lg ml-10">
                <p class="text-white text-2xl">Room List</p>
                <div class="mt-10">
                    <form action="{{ route('rooms.index') }}" method="GET">
                        <div class="flex items-center bg-white rounded-lg p-2">
                            @csrf
                            <button type="submit">
                                <svg class="h-6 w-6 text-blue-500 hover:text-blue-800" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </button>
                            <input type="search" name="search"
                                class="w-full bg-transparent focus:outline-none mx-2 rounded-lg" placeholder="Search">
                        </div>
                    </form>
                </div>
                @foreach ($lists as $list)
                    <div class="flex flex-row bg-white rounded-lg p-4 mt-4">
                        <div class="basis-1/2">
                            <div>
                                <p class="font-bold">Room: {{ $list->name }}</p>
                            </div>
                            <div>
                                <p class="font-bold">Description: {{ $list->description }}</p>
                            </div>
                        </div>
                        <div class="basis-1/2">
                            <button class="bg-gray-700 p-2 text-white rounded w-24 px-8"
                                onclick="showModal('{{ $list->id }}', '{{ $list->name }}', '{{ $list->description }}')">Edit</button>
                            <button onclick="deleteRoom('{{ $list->id }}')"
                                class="bg-red-700 p-2 text-white rounded mt-2 w-24 px-6">Delete</button>
                        </div>
                        <!-- Modal -->
                        <div id="editModal"
                            class="modal fixed w-full h-full top-48 left-0 flex items-center justify-center"
                            style="display: none;">
                            {{-- <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div> --}}

                            <div
                                class="modal-container bg-gray-700 w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                                <!-- Modal content -->
                                <div class="modal-content py-4 text-left px-6">
                                    <!-- Title -->
                                    <div class="flex justify-between items-center pb-3">
                                        <p class="text-2xl font-bold text-white">Edit</p>
                                        <button class="modal-close" onclick="closeModal()">
                                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg"
                                                width="18" height="18" viewBox="0 0 18 18">
                                                <path d="M1 1l16 16m-16 0L17 1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Body -->
                                    <form action="{{ route('rooms.update') }}" method="POST">
                                        @csrf
                                        <div class="mt-10 mb-5">
                                            <input type="hidden" name="id" id="room_id">
                                            <p class="text-white">Room:</p>
                                            <input type="text" id="room_name" name="name"
                                                class="w-full bg-white rounded-lg" placeholder="">
                                        </div>
                                        <div class="mb-5">
                                            <label for="description" class="text-white">Description</label>
                                            <select name="description" id="room_description" class="rounded w-full">
                                                <option>
                                                    Select
                                                </option>
                                                <option value="lab">
                                                    Lab
                                                </option>
                                                <option value="lecture">
                                                    Lecture
                                                </option>
                                            </select>
                                        </div>
                                        <!-- Footer -->
                                        <div class="mt-4 flex justify-end">
                                            <button type="reset"
                                                class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2"
                                                onclick="closeModal()">Cancel</button>
                                            <button type="submit"
                                                class="modal-close px-4 bg-gray-500 p-3 rounded-lg text-white hover:bg-gray-400">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function deleteRoom(id) {
            let text = "Please Confirm to delete\nPress Ok or Cancel.";
            if (confirm(text) == true) {
                $.ajax({
                    type: 'DELETE',
                    url: '/rooms/' + id,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        window.location.href = "rooms"
                    },
                    error: function(xhr) {
                        // Handle the error response, if needed
                        console.log(xhr);
                    }
                });
            }
        }

        function showModal(id, name, desc) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('editModal').style.margin = 'auto';
            document.getElementById('editModal').style.width = '100%';

            document.getElementById('room_id').setAttribute('value', id);
            document.getElementById('room_name').setAttribute('value', name);
            var options = document.getElementById('room_description').options;
            for (var i = 0; i < options.length; i++) {
                if (options[i].value === desc) {
                    options[i].setAttribute('selected', 'selected');
                } else {
                    options[i].removeAttribute('selected');
                }
            }
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>

</x-app-layout>
