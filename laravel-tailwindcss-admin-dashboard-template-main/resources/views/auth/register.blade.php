@extends('layouts.auth')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 text-center mb-4">CREATE AN ACCOUNT</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- NIK -->
                <div class="mb-3">
                    <label for="nik" class="block text-gray-700 font-medium">NIK:</label>
                    <input id="nik" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500"
                        type="text" name="nik" value="{{ old('nik') }}" required autofocus />
                    <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                </div>

                <!-- Full Name -->
                <div class="mb-3">
                    <label for="full_name" class="block text-gray-700 font-medium">Full Name:</label>
                    <input id="full_name" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500"
                        type="text" name="full_name" value="{{ old('full_name') }}" required />
                    <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="block text-gray-700 font-medium">Password:</label>
                    <input id="password" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="block text-gray-700 font-medium">Confirm Password:</label>
                    <input id="password_confirmation" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Department -->
                <div class="mb-3">
                    <label for="department" class="block text-gray-700 font-medium">Department:</label>
                    <select id="department" name="department" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500">
                        <option value="" disabled selected>-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->iddepartments }}">{{ $department->nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('department')" class="mt-1" />
                </div>

                <!-- Division -->
                <div class="mb-3">
                    <label for="division" class="block text-gray-700 font-medium">Division:</label>
                    <select id="division" name="division" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500">
                        <option value="" disabled selected>-- Select Division --</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->division }}">{{ $division->division }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('division')" class="mt-1" />
                </div>

                <!-- Role (Hidden) -->
                <input type="hidden" name="role" value="Users">

                <!-- Submit Button -->
                <div class="mt-4 text-center">
                    <button type="submit"
                        class="w-full bg-gray-700 text-white py-2 px-3 rounded-md shadow-md hover:bg-gray-800 transition">
                        Register
                    </button>
                </div>

                <!-- Already Registered -->
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 font-semibold">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
