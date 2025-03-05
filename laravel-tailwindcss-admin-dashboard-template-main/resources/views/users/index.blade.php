<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Survey Karyawan</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js untuk interaksi UI -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-gray-100 text-gray-700 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-green-600 text-white p-4 shadow-md flex justify-between items-center">
        <h1 class="text-xl font-bold">Survey Karyawan</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md transition">
                Logout
            </button>
        </form>
    </nav>

    <!-- Container utama -->
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-gray-700 text-center mb-6">Form Survey Karyawan</h2>

        {{-- {{ route('survey.store') }} --}}
        <form method="POST" action="">
            @csrf

            @foreach ($departments as $department)
                <div x-data="{ open: false }" class="mb-4 border border-gray-300 shadow-md rounded-lg overflow-hidden">
                    <!-- Header Card -->
                    <div 
                        class="bg-green-600 text-white p-4 flex justify-between items-center cursor-pointer"
                        @click="open = !open"
                    >
                        <span class="font-semibold">{{ $department->nama }}</span>
                        <span class="transition-transform duration-300" :class="open ? 'rotate-180' : ''">▼</span>
                    </div>

                    <!-- Body Card -->
                    <div class="p-4 bg-gray-50" x-show="open" x-transition.scale.origin.top>
                        @foreach ($department->questions as $question)
                            <div class="mb-4">
                                <p class="font-medium text-gray-800">{{ $question->question }}</p>
                                <div class="mt-2 space-y-2">
                                    @foreach (['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'] as $index => $answer)
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="answers[{{ $question->idquestions }}]" value="{{ $index + 1 }}" class="form-radio text-blue-600">
                                            <span class="text-gray-700">{{ $answer }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        <label for="saran" class="block text-gray-700 font-medium">Saran atau Masukan</label>
                        <textarea id="saran" name="saran" rows="4" class="mt-2 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                </div>
                
            @endforeach

            
            
            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Kirim Jawaban
            </button>
        </form>
    </div>

</body>
</html>
