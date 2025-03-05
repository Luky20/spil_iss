@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">INTERNAL SATISFACTION SURVEY</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email:</label>
                <input id="email" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm" type="email" name="email" required autofocus autocomplete="username" />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Password:</label>
                <input id="password" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm" type="password" name="password" required />
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-gray-700 text-white py-2 px-4 rounded-md shadow-md">
                    Sign in
                </button>
            </div>
        </form>
    </div>
@endsection
