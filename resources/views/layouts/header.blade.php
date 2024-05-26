<header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-gray-700">
    {{-- <div class="flex item-center">
        <h1>
        test
        </h1>
    </div> --}}
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <div class="flex items-center">
        <img class="h-10 w-10 flex-none rounded-full bg-gray-50 ring-2 ring-gray-600 m-2" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
        <x-dropdown>
            <x-slot name="trigger">
                <button @click="dropdownOpen = ! dropdownOpen" class="relative block overflow-hidden">
                    {{ Auth::user()->name }}
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('My profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
    <!-- <audio id="alertAudio">
        <source src="{{ asset('assets/alarm.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio> -->
</header>