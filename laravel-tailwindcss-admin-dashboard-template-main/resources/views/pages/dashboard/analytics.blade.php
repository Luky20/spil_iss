<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Survey Analytics</h1>

        <!-- Threshold Guide -->
        <div class="flex gap-4 mb-4">
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 bg-red-500 rounded-full"></span>
                <span>Don't Pass (<4.25)</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 bg-yellow-400 rounded-full"></span>
                <span>Threshold (4.25 - 3.49)</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                <span>Pass (4.5 - 5)</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-800 bg-gradient-to-r from-blue-500 to-blue-700 text-white text-lg">
                        <th class="border border-gray-300 px-4 py-2 text-left">Department</th>
                        <th class="border border-gray-300 px-4 py-2">Total Average</th>
                        <th class="border border-gray-300 px-4 py-2">Willingness to Assist</th>
                        <th class="border border-gray-300 px-4 py-2">Empathy</th>
                        <th class="border border-gray-300 px-4 py-2">Caring</th>
                        <th class="border border-gray-300 px-4 py-2">Agile</th>
                        <th class="border border-gray-300 px-4 py-2">Reliable</th>
                        <th class="border border-gray-300 px-4 py-2">Extra Miles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formattedData as $department)
                        <tr class="text-center">
                            <td class="border border-gray-300 px-4 py-2 font-semibold text-left">{{ $department['department_name'] }}</td>
                            
                            <!-- Total Average -->
                            <td class="border border-gray-300 px-4 py-2 font-semibold {{ $department['total_average'] >= 3.5 ? 'bg-green-500 text-white' : ($department['total_average'] >= 3.25 ? 'bg-yellow-400 text-black' : 'bg-red-500 text-white') }}">
                                {{ number_format($department['total_average'], 2) }}
                            </td>

                            <!-- Loop untuk tiap kategori -->
                            @foreach (['Willingness to Assist', 'Empathy', 'Caring', 'Agile', 'Reliable', 'Extra Miles'] as $category)
                                @php
                                    $score = $department['categories'][$category] ?? '-';
                                    $bgColor = '';
                                    if (is_numeric($score)) {
                                        if ($score >= 4.5) {
                                            $bgColor = 'bg-green-500 text-white';
                                        } elseif ($score >= 4.25) {
                                            $bgColor = 'bg-yellow-400 text-black';
                                        } else {
                                            $bgColor = 'bg-red-500 text-white';
                                        }
                                    }
                                @endphp
                                <td class="border border-gray-300 px-4 py-2 {{ $bgColor }}">
                                    {{ is_numeric($score) ? number_format($score, 2) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
