<!-- resources/views/users/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        {{ __('Create New User') }}
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">{{ session()->get('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="flex justify-between">
        <div class="w-2/5">
            <div class="bg-gray-800 p-4 rounded-lg">
                <form action="{{ route('users.create_user') }}" method="POST">
                    @csrf
                    <p class="text-white text-2xl">Create User Form</p>
                    <div class="mt-10 mb-5">
                        <label for="name" class="text-white">Name</label>
                        <input type="text" name="name" id="name" class="rounded w-full bg-white" placeholder="Name" required>
                    </div>
                    <div class="mt-5 mb-5">
                        <label for="email" class="text-white">Email</label>
                        <input type="email" name="email" id="email" class="rounded w-full bg-white" placeholder="Email" required>
                    </div>
                    <div class="mt-5 mb-5">
                        <label for="password" class="text-white">Password</label>
                        <input type="password" name="password" id="password" class="rounded w-full bg-white" placeholder="Password" required>
                    </div>
                    <div class="mt-5 mb-5">
                        <label for="password_confirmation" class="text-white">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="rounded w-full bg-white" placeholder="Confirm Password" required>
                    </div>
                    <div class="mt-5 mb-5">
                        <label for="role" class="text-white">Role</label>
                        <select name="role" id="role" class="rounded w-full bg-white" required>
                            <option value="">Select Role</option>
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 w-1/5">Save</button>
                        <button type="reset" class="px-4 py-2 rounded-md w-1/5 text-white hover:bg-red-800">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-3/5 ml-4">
            <div class="bg-gray-800 p-4 rounded-lg ml-10">
                <p class="text-white text-2xl">User List</p>
                <div class="mt-10 overflow-y-auto max-h-96">
                    @foreach ($users as $user)
                        <div class="flex flex-row bg-white rounded-lg p-4 mt-4 justify-between items-center">
                            <div>
                                <p class="font-bold">Name: {{ $user->name }}</p>
                                <p class="font-bold">Email: {{ $user->email }}</p>
                                <p class="font-bold">Role: {{ $user->roles[0]->title }}</p>
                            </div>
                            <div>
                                <form action="{{ route('users.destroy_user', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-700 p-2 text-white rounded">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
