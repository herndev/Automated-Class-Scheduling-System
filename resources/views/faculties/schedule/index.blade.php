<x-app-layout>
    <x-slot name="header">
        {{ __('Faculty Schedule') }}
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
        <div class="w-full">
            <div class="w-2/5 float-left">
                <p class="text-xl font-bold">Faculty Schedules</p>
            </div>
            <div class="w-3/5 float-right">
                <div x-data="{ isOpen: false }">
                    <button type="button" @click="isOpen = true"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 w-1/5 float-right">NEW</button>
                    <div x-show="isOpen"
                        class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
                        <!-- Modal content -->
                        <div class="bg-white p-8 rounded shadow-md w-3/4">

                            <!-- Modal content goes here -->
                            <p class="text-xl font-bold">New Schedule</p>
                            <form action="{{ route('appointment.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4">
                                        <label for="user_id" class="">Faculty</label>
                                        <select onchange="selectFaculty(this.value)" name="user_id" id="user_id" class="rounded w-full mb-2" required>
                                            <option>
                                                Select
                                            </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="p-4">
                                        <label for="course_id" class="">Subject</label>
                                        <select name="course_id" id="course_id" class="rounded w-full mb-2" required>
                                            <option>
                                                Select
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4">
                                        <p class="">Month Start</p>
                                        <input type="month" name="month_start" class="w-full bg-white rounded-lg"
                                            placeholder="">
                                    </div>
                                    <div class="p-4">
                                        <p class="">Month End</p>
                                        <input type="month" name="month_end" class="w-full bg-white rounded-lg"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    {{-- <div class="p-4">
                                        <p class="">Semester</p>
                                        <input type="number" name="semester" class="w-full bg-white rounded-lg"
                                            placeholder="">
                                    </div> --}}
                                    <div class="p-4">
                                        <p class="">Description</p>
                                        <input type="text" name="description" class="w-full bg-white rounded-lg"
                                            placeholder="">
                                    </div>
                                </div>
                                <button type="reset" @click="isOpen = false"
                                    class="float-right px-4 py-2 rounded-md border w-1/5 text-black hover:bg-red-800 hover:text-white">Cancel</button>
                                <button type="submit"
                                    class="float-right bg-blue-500 hover:bg-blue-800 text-white px-4 py-2 rounded-md mr-4 w-1/5">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <select onchange="selectUser(this.value)" name="type" id="type" class="rounded w-1/2 mb-2">
                    <option>
                        Select
                    </option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if($user->id == $user_id) selected @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Responsive table of appointments -->
            @if (count($appointments) != 0)
                <div class="overflow-x-auto mt-5">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="w-full bg-gray-100 border-b">
                                <th class="py-2 px-4 text-left">Subject</th>
                                <th class="py-2 px-4 text-left">Room</th>
                                <th class="py-2 px-4 text-left">Time</th>
                                <th class="py-2 px-4 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-b">
                                    <td class="py-2 px-4"> {{ $appointment->subject }} {{ $appointment->subjectCode }}</td>
                                    <td class="py-2 px-4">{{ $appointment->room }}</td>
                                    <td class="py-2 px-4">{{ date("g:i A", strtotime($appointment->time_start)) }} - {{ date("g:i A", strtotime($appointment->time_end)) }}</td>
                                    <td class="py-2 px-4">
                                        <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif


            <div class="rounded-lg bg-white ml-4 mt-14" style="border-radius: 5px;">
                <div id="calendar" class="p-6"></div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript"></script>

</x-app-layout>
<script>
    var dd = <?php echo json_encode($scheds); ?>;
    var cc = <?php echo json_encode($courses); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '8:00:00',
            slotMaxTime: '21:00:00',
            events: @json($events),
        });
        calendar.render();
    });

    function selectUser(id) {
        $.ajax({
            type: 'GET',
            url: 'schedule',
            data: {
                _token: '{{ csrf_token() }}',
                search: id,
            },
            success: function(data) {
                window.location.href = "schedule?_token={{ csrf_token() }}&search=" + id
            },
            error: function(xhr) {
                // Handle the error response, if needed
                console.log(xhr);
            }
        });
    }

    function selectFaculty(id) {
        var ddf = dd[id.toString()];

        // Reference to the select element
        const courseSelect = document.getElementById('course_id');
        // Empty the select element
        courseSelect.innerHTML = '';
       
        // Filter courses, excluding those with id equal to 4
        // const filteredCourses = courses.filter(course => course.id !== 4);
        var filteredCourses = cc;
        ddf.forEach(e => {
            filteredCourses = filteredCourses.filter(course => course.id !== parseInt(e, 10))
        });

        const doption = document.createElement('option');
        doption.textContent = `Select`;
        courseSelect.appendChild(doption);

        // Populate the select element with the filtered courses
        filteredCourses.forEach(course => {
            const option = document.createElement('option');
            option.value = course.id;
            option.textContent = `${course.subject} ${course.subjectCode}`;
            courseSelect.appendChild(option);
        });
    }
</script>
