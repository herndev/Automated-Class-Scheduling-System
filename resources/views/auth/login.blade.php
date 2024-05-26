<x-guest-layout>
    <a href="/" class="flex justify-center items-center">
        <img src="assets/logotrans.png" alt="logo" style="width: 150px; height: 150px">
    </a>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 mt-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}" class="mt-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-label for="email" :value="__('Email')" />
            <x-input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus />
        </div>

        <!-- Password -->
        <div class="mt-3">
            <x-label for="password" :value="__('Password')" />
            <x-input type="password" name="password" id="password" required autocomplete="current-password" />
        </div>

        <div class="flex justify-between mt-4">
            <!-- Remember Me -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox text-indigo-600" name="remember">
                    <span class="mx-2 text-gray-600 text-sm">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div>
                <a class="block text-sm fontme text-red-700 hover:underline"
                    href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
            
        </div>
        <div class="float-right mb-4">
            @if (Route::has('password.request'))
                <a class="block text-sm fontme text-red-700 hover:underline"
                    href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            @endif
        </div>

        <div class="mt-6">
            <x-button class="w-full bg-red-700">
                {{ __('Log in') }}
            </x-button>
        </div>

    </form>
</x-guest-layout>
