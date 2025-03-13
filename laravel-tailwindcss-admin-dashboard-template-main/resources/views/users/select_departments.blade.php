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

        <form method="POST" action="{{ route('survey.store_selected_departments') }}" onsubmit="return validateSelection()">
            @csrf

            <p class="text-sm text-gray-700 mb-3">
                You must select at least <strong>5</strong> departments. You can select more.
            </p>

            <div id="department-list">
                @foreach ($departments as $department)
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="selected_departments[]" value="{{ $department->iddepartments }}" 
                                class="form-checkbox text-green-500 department-checkbox" 
                                onchange="updateSelection()">
                            <span class="ml-2">{{ $department->nama }}</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Error Message -->
            <p id="error-message" class="text-red-500 text-sm mt-2 hidden">
                You must select at least <strong>5</strong> departments before proceeding.
            </p>

            <div class="mt-4">
                <button type="submit" id="submit-button" class="w-full bg-green-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    Proceed to Survey
                </button>
            </div>
        </form>
    </div>

    <script>
        function updateSelection() {
            let checkedCount = document.querySelectorAll('.department-checkbox:checked').length;
            let errorMessage = document.getElementById('error-message');
            let submitButton = document.getElementById('submit-button');

            // Jika sudah memilih minimal 5, enable tombol
            if (checkedCount >= 5) {
                errorMessage.classList.add('hidden');
                submitButton.disabled = false;
            } else {
                errorMessage.classList.remove('hidden');
                submitButton.disabled = true;
            }
        }

        function validateSelection() {
            let checkedCount = document.querySelectorAll('.department-checkbox:checked').length;
            if (checkedCount < 5) {
                alert("You must select at least 5 departments before proceeding.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
