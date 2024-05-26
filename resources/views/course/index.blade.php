<x-app-layout>
    <x-slot name="header">
        {{ __('Course') }}
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
                <form action="{{ route('course.store') }}" method="POST">
                    @csrf
                    <p class="text-white text-2xl mb-4">Course Form</p>
                    {{-- <input type="text" id="daysInput" placeholder="Enter days (e.g., Monday, Tuesday)">
                    <span onclick="addDay()">Add</span>
                    <div id="selectedDays"></div> --}}
                    <label for="type" class="text-white">Course List</label>
                    <select name="type" id="type" class="rounded w-full mb-2">
                        <option>
                            Select
                        </option>
                        <option value="BSIT">
                            BSIT
                        </option>
                        <option value="BSCS">
                            BSCS
                        </option>
                        <option value="BSIS">
                            BSIS
                        </option>
                        <option value="BSEMC">
                            BSEMC
                        </option>
                    </select>
                    {{-- <div class="mb-2">
                        <p class="text-white">Year:</p>
                        <input type="number" name="year" class="w-full bg-white rounded-lg" placeholder="">
                    </div> --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <p class="text-white">Subject:</p>
                            <input type="text" name="subject" class="w-full bg-white rounded-lg" placeholder="">
                        </div>
                        <div class="mb-2">
                            <p class="text-white">Year:</p>
                            <input type="text" name="year" class="w-full bg-white rounded-lg" placeholder="">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <p class="text-white">Subject Code:</p>
                            <input type="text" name="subjectCode" class="w-full bg-white rounded-lg" placeholder="">
                        </div>
                        <div class="mb-2">
                            <p class="text-white">Semester:</p>
                            <input type="text" name="semester" class="w-full bg-white rounded-lg" placeholder="">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="room_id" class="text-white">Room</label>
                        <select name="room_id" id="room_id" class="rounded w-full mb-2">
                            <option>
                                Select
                            </option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Description:</p>
                        <input type="text" name="description" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <label for="status" class="text-white">Status</label>
                        <select name="status" id="status" class="rounded w-full mb-2">
                            <option>
                                Select
                            </option>
                            <option value="available">
                                Available
                            </option>
                            <option value="N/A">
                                N/A
                            </option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Units:</p>
                        <input type="text" name="unit" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Days:</p>
                        <input type="text" name="day" id="daysInput" class="w-full bg-white rounded-lg"
                            placeholder="Enter days (e.g., Monday, Tuesday)">
                        {{-- <label for="day" class="text-white">Day</label>
                        <select name="day" id="day" class="rounded w-full mb-2">
                            <option>
                                Select
                            </option>
                            <option value="Monday">
                                Monday
                            </option>
                            <option value="Tuesday">
                                Tuesday
                            </option>
                            <option value="Wednesday">
                                Wednesday
                            </option>
                            <option value="Thursday">
                                Thursday
                            </option>
                            <option value="Friday">
                                Friday
                            </option>
                        </select> --}}
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Time Start:</p>
                        <input type="time" name="time_start" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Time End:</p>
                        <input type="time" name="time_end" class="w-full bg-white rounded-lg" placeholder="">
                    </div>
                    <div class="mb-2">
                        <p class="text-white">Block:</p>
                        <input type="text" name="block" class="w-full bg-white rounded-lg" placeholder="">
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
                <p class="text-white text-2xl">Course List</p>
                <div class="mt-10">
                    <form action="{{ route('course.index') }}" method="GET">
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
                <div class="overflow-y-auto">
                    @foreach ($lists as $list)
                        <div class="flex flex-row bg-white rounded-lg p-4 mt-4">
                            <div class="basis-1/2">
                                <div>
                                    <p class="font-bold">Course Type: {{ $list->type }}</p>
                                </div>
                                {{-- <div>
                                <p class="font-bold">Year:
                                    {{ $list->year == '2' || $list->year == '3' || $list->year == '4' ? $list->year . 'nd' : $list->year . 'st' }}
                                </p>
                            </div> --}}
                                <div>
                                    <p class="font-bold">Subject: {{ $list->subject }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Subject Code: {{ $list->subjectCode }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Room: {{ $list->name }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Block: {{ $list->block }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Unit: {{ $list->unit }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Time: {{ $list->time_start . ' - ' . $list->time_end }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Status: {{ $list->status }}</p>
                                </div>
                                <div>
                                    <p class="font-bold">Description: {{ $list->description }}</p>
                                </div>
                            </div>
                            <div class="basis-1/2">
                                <button class="bg-gray-700 p-2 text-white rounded w-24 px-8"
                                    onclick="showModal('{{ $list->id }}', '{{ $list->type }}', '{{ $list->subject }}', '{{ $list->subjectCode }}', '{{ $list->block }}', '{{ $list->unit }}', '{{ $list->time_start }}', '{{ $list->time_end }}', '{{ $list->status }}', '{{ $list->description }}')">Edit</button>
                                <button onclick="deleteCourse('{{ $list->id }}')"
                                    class="bg-red-700 p-2 text-white rounded mt-2 w-24 px-6">Delete</button>
                            </div>
                            <!-- Modal -->
                            <div id="editModal"
                                class="modal fixed w-full h-full top-4 left-0 flex items-center justify-center overflow-y-auto"
                                style="display: none;">
                                {{-- <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div> --}}

                                <div
                                    class="modal-container bg-gray-700 w-11/12 md:max-w-2xl mx-auto rounded shadow-lg z-50 overflow-y-auto">

                                    <!-- Modal content -->
                                    <div class="modal-content py-4 w-full text-left px-6">
                                        <!-- Title -->
                                        <div class="flex justify-between items-center pb-3">
                                            <p class="text-2xl font-bold text-white">Edit</p>
                                            <button class="modal-close" onclick="closeModal()">
                                                <svg class="fill-current text-black"
                                                    xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18">
                                                    <path d="M1 1l16 16m-16 0L17 1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Body -->
                                        <form action="{{ route('course.update') }}" method="POST">
                                            @csrf
                                            <div class="flex flex-row">
                                                <input type="hidden" name="id" id="c_id">
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Course:</p>
                                                        <input type="text" id="c_type" name="type"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Subject:</p>
                                                        <input type="text" id="c_subject" name="subject"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Subject Code:</p>
                                                        <input type="text" id="c_code" name="subjectCode"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Block:</p>
                                                        <input type="text" id="c_block" name="block"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Time Start:</p>
                                                        <input type="time" id="t_start" name="time_start"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Time End:</p>
                                                        <input type="time" id="t_end" name="time_end"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Unit:</p>
                                                        <input type="text" id="c_unit" name="unit"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        {{-- <p class="text-white">Status:</p>
                                                        <input type="text" id="c_status" name="status"
                                                            class="w-full bg-white rounded-lg" placeholder=""> --}}
                                                        <label for="status" class="text-white">Status</label>
                                                        <select name="status" id="c_status"
                                                            class="rounded w-full mb-2">
                                                            <option>
                                                                Select
                                                            </option>
                                                            <option value="available">
                                                                Available
                                                            </option>
                                                            <option value="N/A">
                                                                N/A
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="basis-1/2 pr-2">
                                                    <div class="mb-5">
                                                        <p class="text-white">Description:</p>
                                                        <input type="text" id="c_desc" name="description"
                                                            class="w-full bg-white rounded-lg" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Footer -->
                                            <div class="mt-4 flex justify-end">
                                                <button type="reset"
                                                    class="px-4 bg-transparent p-3 rounded-lg text-white hover:bg-gray-100 hover:text-red-400 mr-2"
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
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function addDay() {
            // Get the input value
            var input = document.getElementById("daysInput").value.trim();

            // If input is empty, do nothing
            if (!input) return;

            // Split the input into an array of days
            var days = input.split(',');

            // Display the selected days
            var selectedDaysDiv = document.getElementById("selectedDays");
            days.forEach(function(day) {
                // Create a span element for each day
                var span = document.createElement("span");
                span.textContent = day.trim();
                span.className = "selectedDay";

                // Append the span to the selectedDaysDiv
                selectedDaysDiv.appendChild(span);
            });

            // Clear the input field
            document.getElementById("daysInput").value = "";
        }

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

        function showModal(id, c_type, subject, subjectCode, block, unit, t_start, t_end, status, des) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('editModal').style.margin = 'auto';
            document.getElementById('editModal').style.width = '100%';

            document.getElementById('c_id').setAttribute('value', id);
            document.getElementById('c_type').setAttribute('value', subject);
            document.getElementById('c_subject').setAttribute('value', subject);
            document.getElementById('c_code').setAttribute('value', subjectCode);
            document.getElementById('c_block').setAttribute('value', block);
            document.getElementById('c_unit').setAttribute('value', unit);
            document.getElementById('t_start').setAttribute('value', t_start);
            document.getElementById('t_end').setAttribute('value', t_end);
            // document.getElementById('c_status').setAttribute('value', status);
            var options = document.getElementById('c_status').options;
            for (var i = 0; i < options.length; i++) {
                if (options[i].value === status) {
                    options[i].setAttribute('selected', 'selected');
                } else {
                    options[i].removeAttribute('selected');
                }
            }
            document.getElementById('c_desc').setAttribute('value', des);
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>

    <style>
        .selectedDay {
            display: inline-block;
            margin-right: 5px;
            padding: 5px;
            background-color: #f0f0f0;
            border-radius: 3px;
        }
    </style>

</x-app-layout>
