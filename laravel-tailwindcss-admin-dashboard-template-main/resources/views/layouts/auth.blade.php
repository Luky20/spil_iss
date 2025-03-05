<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Internal Satisfaction Survey</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #8a2be2, #32cd32);
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative">

    <!-- Logo SPIL di pojok kanan atas -->
    <div class="absolute top-5 right-5">
        <img src="{{ asset('images/Logospil.png') }}" alt="SPIL Logo" class="w-20">
    </div>

    <!-- Container utama -->
    <div class="w-full max-w-5xl flex items-center justify-between p-12">
        
        <!-- Judul -->
        <div class="text-white font-bold text-5xl leading-tight">
            INTERNAL <br> SATISFACTION <br> SURVEY
        </div>

        <!-- Form Login -->
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
            @yield('content')
        </div>

    </div>

</body>
</html>
