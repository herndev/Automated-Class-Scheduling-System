<x-guest-layout>
    <a href="/" class="flex justify-center items-center">
        <img src="assets/logotrans.png" alt="logo" style="width: 150px; height: 150px">
    </a>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    <form method="POST" action="{{ route('register') }}">
    @csrf

        <!-- Name -->
        <div>
            <x-label for="name" :value="__('Name')"/>
            <x-input type="text"
                     name="name"
                     id="name"
                     value="{{ old('name') }}"
                     required
                     autofocus
            />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-label for="email" :value="__('Email')"/>
            <x-input type="email"
                     name="email"
                     id="email"
                     value="{{ old('email') }}"
                     required/>
        </div>

        <!-- Password -->
        <div class="mt-3">
            <x-label for="password" :value="__('Password')"/>
            <x-input type="password"
                     name="password"
                     id="password"
                     required
                     autocomplete="current-password"
            />
        </div>

        <!-- Confirm Password -->
        <div class="mt-3">
            <x-label for="password_confirmation" :value="__('Confirm Password')"/>
            <x-input type="password"
                     name="password_confirmation"
                     id="password_confirmation"
                     required
            />
        </div>

        <!-- Role Selection -->
        <div class="mt-3">
            <x-label for="role" :value="__('Role')"/>
            <select name="role" id="role" class="block mt-1 w-full" required>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>{{ __('Student') }}</option>
                <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>{{ __('Instructor') }}</option>
            </select>
        </div>

        <div class="flex flex-col items-end mt-4">
            <x-button class="w-full">
                {{ __('Register') }}
            </x-button>

            <a class="mt-4 text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
