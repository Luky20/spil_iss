<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Departments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="max-w-lg w-full bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold text-center mb-4">Select Departments to Survey</h2>

        <form method="POST" action="{{ route('survey.store_selected_departments') }}">
            @csrf

            <p class="text-sm text-gray-700 mb-3">Select up to <strong>10</strong> departments for the survey.</p>

            <div id="department-list">
                @foreach ($departments as $department)
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="selected_departments[]" value="{{ $department->iddepartments }}" 
                                class="form-checkbox text-green-500 department-checkbox" 
                                onchange="limitSelection()">
                            <span class="ml-2">{{ $department->nama }}</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <p id="error-message" class="text-red-500 text-sm mt-2 hidden">You can only select up to 10 departments.</p>

            <div class="mt-4">
                <button type="submit" id="submit-button" class="w-full bg-green-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-700">
                    Proceed to Survey
                </button>
            </div>
        </form>
    </div>

    <script>
        function limitSelection() {
            let checkboxes = document.querySelectorAll('.department-checkbox');
            let checkedCount = document.querySelectorAll('.department-checkbox:checked').length;
            let errorMessage = document.getElementById('error-message');
            let submitButton = document.getElementById('submit-button');

            if (checkedCount >= 10) {
                errorMessage.classList.remove('hidden');
                submitButton.disabled = false;

                // Disable checkbox yang belum dipilih
                checkboxes.forEach(checkbox => {
                    if (!checkbox.checked) {
                        checkbox.disabled = true;
                    }
                });
            } else {
                errorMessage.classList.add('hidden');
                submitButton.disabled = false;

                // Enable kembali semua checkbox jika kurang dari 10
                checkboxes.forEach(checkbox => {
                    checkbox.disabled = false;
                });
            }
        }
    </script>
</body>
</html>
