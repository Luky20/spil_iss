<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-xs rounded-xl">
    <div class="px-5 pt-5">
        <header class="flex justify-between items-start mb-2">
            <h2 class="text-lg font-semibold text-gray-800">HCCA</h2>
            <!-- Menu button -->
            <div class="relative inline-flex" x-data="{ open: false }">
                <button
                    class="rounded-full"
                    :class="open ? 'bg-gray-100 text-gray-500': 'text-gray-400 hover:text-gray-500'"          
                    aria-haspopup="true"
                    @click.prevent="open = !open"
                    :aria-expanded="open"
                >
                    <span class="sr-only">Menu</span>
                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                        <circle cx="16" cy="16" r="2" />
                        <circle cx="10" cy="16" r="2" />
                        <circle cx="22" cy="16" r="2" />
                    </svg>
                </button>
                <div
                    class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white border border-gray-200 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1"                
                    @click.outside="open = false"
                    @keydown.escape.window="open = false"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak                
                >
                    <ul>
                        <li>
                            <a class="font-medium text-sm text-gray-600 hover:text-gray-800 flex py-1 px-3" href="#">Option 1</a>
                        </li>
                        <li>
                            <a class="font-medium text-sm text-gray-600 hover:text-gray-800 flex py-1 px-3" href="#">Option 2</a>
                        </li>
                        <li>
                            <a class="font-medium text-sm text-red-500 hover:text-red-600 flex py-1 px-3" href="#">Remove</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="text-xs font-semibold text-gray-400 uppercase mb-1">Survey Completion</div>
        <div class="flex items-center justify-center">
            <canvas id="chart-acme-plus" class="w-24 h-24"></canvas>
        </div>
        <p class="text-center text-gray-600 mt-2 text-sm">75% Completed</p>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let ctx = document.getElementById("chart-acme-plus").getContext("2d");
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [75, 25], // 75% Completed, 25% Remaining
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
    });
</script>
