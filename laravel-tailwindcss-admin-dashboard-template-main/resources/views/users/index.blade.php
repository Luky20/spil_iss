<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Internal Survey Satisfaction</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-700 flex justify-center items-center">

    <!-- Container utama -->
    <div class="max-w-5xl w-full bg-white shadow-lg rounded-lg p-6 border border-purple-400">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-bold text-purple-600">Internal Survey Satisfaction 2025 (Batch 1)</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Log out
                </button>
            </form>
        </div>

        <!-- Progress Bar -->
        <div class="mt-4">
            <div class="flex justify-between text-sm text-gray-600">
                <span>{{ round($progressPercentage) }}%</span>
                <span>Department {{ $completedDepartments }}/{{ $totalDepartments }}</span>
            </div>
            <div class="w-full bg-gray-300 rounded-full h-2 mt-1">
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>

        <!-- Survey Content -->
        <div class="mt-6 text-center font-semibold text-gray-800">
            Silahkan nilai beberapa pertanyaan di bawah ini sesuai dengan yang Anda alami
        </div>

        <!-- Skala Likert -->
        <div class="flex justify-center gap-4 mt-4">
            @foreach ($answers as $answer)
                <div class="text-center">
                    <div class="w-8 h-8 rounded-full inline-block" style="background-color: {{ $loop->index == 0 ? '#FF6961' : ($loop->index == 1 ? '#FFA07A' : ($loop->index == 2 ? '#90EE90' : '#2E8B57')) }};">
                    </div>
                    <div class="text-sm mt-1">{{ $answer->nama }}</div>
                </div>
            @endforeach
        </div>

        <!-- Pertanyaan -->
        <form method="POST" action="{{ route('survey.store') }}" class="mt-4">
            @csrf
            @foreach ($questions as $question)
                <div class="p-4 bg-white shadow-md rounded-md mt-4">
                    <p class="font-medium text-gray-800">{{ $question->questions }}</p>
                    <div class="flex justify-center gap-4 mt-2">
                        @foreach ($answers as $answer)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="answers[{{ $question->idquestions }}]" value="{{ $answer->idanswers }}" class="hidden">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex justify-center items-center hover:shadow-md"
                                     style="background-color: {{ $loop->index == 0 ? '#FF6961' : ($loop->index == 1 ? '#FFA07A' : ($loop->index == 2 ? '#90EE90' : '#2E8B57')) }};">
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                    Kirim Jawaban
                </button>
            </div>
        </form>
    </div>

</body>
</html>
