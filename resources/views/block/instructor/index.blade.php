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
                <p class="text-xl font-bold">Instructor Schedule</p>
            </div>
            <div class="rounded-lg bg-white ml-4 h-3/4 mt-14" style="border-radius: 5px;">
                <div id="calendar" class="p-6"></div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript"></script>

</x-app-layout>
<script>
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
</script>
