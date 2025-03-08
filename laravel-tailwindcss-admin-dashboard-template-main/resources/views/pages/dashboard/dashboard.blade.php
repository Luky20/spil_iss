<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📊 Survey Dashboard</h1>
        </div>

        <!-- Tabel Progress Per Divisi -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Survey Completion Status</h2>
            <table class="w-full border-collapse border border-gray-300 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-blue-700 text-white text-lg">
                        <th class="border border-gray-300 px-4 py-3">Division</th>
                        <th class="border border-gray-300 px-4 py-3">Total Employees</th>
                        <th class="border border-gray-300 px-4 py-3">Completed</th>
                        <th class="border border-gray-300 px-4 py-3">Percentage</th>
                        <th class="border border-gray-300 px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100 text-center">
                    @foreach ($surveyCompletion as $divisionData)
                        <tr class="border border-gray-300 hover:bg-gray-200 transition">
                            <td class="px-4 py-3 font-medium text-gray-700">{{ $divisionData['division'] }}</td>
                            <td class="px-4 py-3">{{ $divisionData['total_employees'] }}</td>
                            <td class="px-4 py-3">{{ $divisionData['completed_surveys'] }}</td>
                            <td class="px-4 py-3 text-lg font-semibold text-blue-600">{{ number_format($divisionData['percentage'], 2) }}%</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-lg text-white 
                                    {{ $divisionData['percentage'] >= 80 ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $divisionData['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pie Charts Progress Per Divisi -->
        <div class="grid grid-cols-12 gap-6">
            @foreach ($surveyCompletion as $index => $divisionData)
                <div class="flex flex-col col-span-6 sm:col-span-4 xl:col-span-3 bg-white shadow-lg rounded-lg p-4 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 text-center">{{ $divisionData['division'] }}</h3>
                    <canvas id="chart-{{ $index }}" class="w-24 h-24 mx-auto"></canvas>
                    <p class="text-center text-gray-600 mt-2 text-sm font-bold">
                        {{ number_format($divisionData['percentage'], 2) }}% Completed
                    </p>
                </div>
            @endforeach
        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($surveyCompletion as $index => $divisionData)
                let ctx{{ $index }} = document.getElementById("chart-{{ $index }}").getContext("2d");
                new Chart(ctx{{ $index }}, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [{{ $divisionData['percentage'] }}, {{ 100 - $divisionData['percentage'] }}],
                            backgroundColor: ['#4CAF50', '#E0E0E0'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            @endforeach
        });
    </script>
</x-app-layout>
