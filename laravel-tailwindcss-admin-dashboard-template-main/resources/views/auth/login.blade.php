@extends('layouts.auth')

@section('content')
    <h2 class="text-xl font-bold text-gray-800 text-center mb-6">INTERNAL SATISFACTION SURVEY</h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="nik" class="block text-gray-700 font-medium">NIK:</label>
            <input id="nik" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500" type="text" name="nik" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium">Password:</label>
            <input id="password" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-500 focus:border-green-500" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Forgot Password -->
        <div class="mb-4 text-right">
            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-800" href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="w-full bg-gray-700 text-white py-2 px-4 rounded-md shadow-md hover:bg-gray-800 transition">
                Sign in
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-4 text-center">
        @if (Route::has('register'))
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 font-semibold">
                    Register here
                </a>
            </p>
        @endif
    </div>
@endsection
