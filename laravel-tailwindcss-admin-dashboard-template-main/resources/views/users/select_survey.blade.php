<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Survey</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-purple-600 to-green-500">
    
    <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-lg font-bold text-gray-800">CHOOSE SURVEY:</h1>

        <div class="mt-6 space-y-4">
            <a href="{{ route('survey.select_departments') }}" 
               class="block text-xl font-bold text-blue-700 underline hover:text-blue-900 transition">
                ISS FOR DEPARTMENT
            </a>
            <a href="{{ route('survey.branch') }}" 
               class="block text-xl font-bold text-blue-700 underline hover:text-blue-900 transition">
                ISS FOR BRANCH
            </a>
        </div>

        <p class="text-sm text-gray-500 mt-6">Panduan Mengisi Survey</p>
    </div>

</body>
</html>
