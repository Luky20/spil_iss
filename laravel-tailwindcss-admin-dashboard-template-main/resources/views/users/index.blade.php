<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Internal Survey Satisfaction</title>

    <style>
        .likert-option {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: black;
            transition: all 0.2s ease-in-out;
        }

        .likert-option:hover {
            transform: scale(1.1);
        }

        .selected {
            color: white !important; /* Warna teks tetap terlihat di bola yang dipilih */
        }
    </style>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-700 flex justify-center items-center" style="background: linear-gradient(135deg, #7B60D1, #24B47E);">

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
                <span>Progress: <span id="progress-count">{{ $completedDepartments }}</span>/{{ $totalDepartments }}</span>
            </div>
            <div id="progress-bar" class="bg-green-500 h-2 rounded-full" 
                style="width: {{ ($totalDepartments > 0) ? ($completedDepartments / $totalDepartments) * 100 : 0 }}%">
            </div>
        </div>

        <!-- Survey Content -->
        <div class="mt-6 text-center font-semibold text-gray-800">
            Silahkan nilai beberapa pertanyaan di bawah ini sesuai dengan yang Anda alami untuk 
            <strong>{{ $currentDepartment->department_name }}</strong>
        </div>

        <!-- Skala Likert -->
        <div class="flex justify-center gap-4 mt-4">
            @foreach ($answers as $answer)
                <div class="text-center">
                    <div class="likert-btn likert-option rounded-full cursor-pointer"
                        data-value="{{ $answer->idanswers }}"
                        style="background-color:
                            @if($answer->idanswers == 1) #D32F2F
                            @elseif($answer->idanswers == 2) #FF7043
                            @elseif($answer->idanswers == 3) #FFD54F
                            @elseif($answer->idanswers == 4) #66BB6A
                            @else #388E3C
                            @endif;">
                        {{ $answer->idanswers }} <!-- Angka dalam bola -->
                    </div>
                    <div class="text-sm mt-1">{{ $answer->nama }}</div>
                </div>  
            @endforeach
        </div>

        <!-- Pertanyaan -->
        <form method="POST" id="survey-form">
            @csrf
            <input type="hidden" name="department_id" id="department-id" value="{{ $currentDepartment->idepartments_ke }}">

            @foreach ($questions as $question)
                <div class="p-4 bg-white shadow-md rounded-md mt-4">
                    <p class="font-medium text-gray-800">{{ $question->questions }}</p>
                    <div class="flex justify-center gap-4 mt-2">
                        @foreach ($answers as $answer)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="answers[{{ $question->idquestions }}]" value="{{ $answer->idanswers }}" class="hidden" required>
                                <div class="likert-option w-10 h-10 rounded-full border-2 border-gray-300 flex justify-center items-center hover:shadow-md"
                                    data-question="{{ $question->idquestions }}"
                                    data-answer="{{ $answer->idanswers }}"
                                    style="background-color: transparent;">
                                    {{ $answer->idanswers }} <!-- Angka tetap muncul -->
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Next/Submit Button -->
            <div class="mt-6 text-center">
                <button type="button" id="next-btn" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                    Next
                </button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            // Klik untuk memilih jawaban (Likert scale)
            $('.likert-option').click(function () {
                let questionId = $(this).data('question');
                let answerId = $(this).data('answer');

                // Hapus warna sebelumnya untuk pertanyaan yang sama
                $(`[data-question="${questionId}"]`).css({
                    'background-color': 'transparent',
                    'color': 'black'
                });

                // Warna sesuai ID Jawaban
                let colorMap = {
                    1: '#D32F2F', // Sangat Tidak Setuju (Merah Gelap)
                    2: '#FF7043', // Tidak Setuju (Oranye)
                    3: '#FFD54F', // Netral (Kuning)
                    4: '#66BB6A', // Setuju (Hijau Muda)
                    5: '#388E3C'  // Sangat Setuju (Hijau Gelap)
                };

                if (colorMap[answerId]) {
                    $(this).css({
                        'background-color': colorMap[answerId],
                        'color': 'white' // Warna teks agar tetap terlihat
                    });
                }
            });

            // Klik Next atau Submit
            $('#next-btn').click(function () {
                let allAnswered = true;

                // Cek apakah semua pertanyaan sudah dijawab
                $('input[type="radio"]').each(function () {
                    let questionName = $(this).attr('name');
                    if ($(`input[name="${questionName}"]:checked`).length === 0) {
                        allAnswered = false;
                    }
                });

                if (!allAnswered) {
                    alert("Harap isi semua pertanyaan sebelum lanjut.");
                    return;
                }

                let formData = $('#survey-form').serialize();

                $.ajax({
                    url: '{{ route("survey.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#progress-count').text(data.completedDepartments);
                        $('#progress-bar').css('width', data.progressPercentage + '%');

                        if (data.isLastPage) {
                            $('#next-btn').text('Submit').attr('id', 'submit-btn');
                        } else {
                            window.location.reload(); // Pindah ke department berikutnya
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseJSON);
                        alert("Terjadi kesalahan: " + (xhr.responseJSON.message || "Cek kembali jawaban Anda."));
                    }
                });
            });
        });
    </script>
</body>
</html>
