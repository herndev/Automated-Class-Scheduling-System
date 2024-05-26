<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'XUScheduling System') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
        @include('layouts.navigation')

        <div class="flex overflow-hidden flex-col flex-1">
            @include('layouts.header')

            <main class="overflow-y-auto overflow-x-hidden flex-1 bg-gray-200">
                <div class="container px-6 py-8 mx-auto">

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    const audio = document.getElementById('alertAudio');
    const audioFire = document.getElementById('alertFire');
    // Initialize Laravel Echo and configure it according to your needs
    // const echo = new Echo({
    //     broadcaster: 'pusher',
    //     key: '{{ config(' broadcasting.connections.pusher.key ') }}',
    //     cluster: '{{ config('
    //     broadcasting.connections.pusher.options.cluster ') }}',
    //     encrypted: true,
    // });
    // const audio = new Audio('assets/alarm.mp3');

    // Pag-alarm sa speaker
    // function alarm() {
    //     audio.play();
    //     alert('Admin notification received!');
    // }

    // window.Echo = new Echo({
    //     broadcaster: 'pusher',
    //     key: '7d59edc4d06010b69922',
    //     cluster: 'ap3',
    //     forceTLS: true
    // });
    // Echo.channel('notify-channel')
    //     .listen('NewPostAdded', (e) => {
    //         console.log(e);
    //         audio.play();
    //     });

    // // Listen for the notification event
    // echo.private(`user.${auth()->id()}`)
    //     .notification((notification) => {
    //         // Play the audio when a notification is received
    //         const audio = document.getElementById('alertAudio');
    //         audio.play();

    //         // You can also display the notification message to the user here
    //         alert(notification.message);
    //     });
    // const audio = document.getElementById('alertAudio');
    // audio.play();
</script>

</html>