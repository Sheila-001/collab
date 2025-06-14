@extends('components.admin-layout')

@section('content')
    {{-- Add Chart.js library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container-fluid px-4">
        <h1 class="h3 mb-4">Non-Monetary Donations Report</h1>

        <!-- Summary Card -->
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-gray-600 mb-1">Total Non-Monetary Donations</div>
                        <div class="text-xl font-semibold text-gray-800">{{ number_format($totalCount) }}</div>
                    </div>
                    <i class="fas fa-box fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h6 class="text-lg font-semibold mb-4">Monthly Donations</h6>
                <canvas id="monthlyChart"></canvas>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h6 class="text-lg font-semibold mb-4">Donations by Category</h6>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h6 class="text-lg font-semibold">Donation Summary</h6>
                <div class="flex space-x-2">
                    <button onclick="showSummary('monthly')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Monthly</button>
                    <button onclick="showSummary('yearly')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Yearly</button>
                </div>
            </div>
            <div id="summaryContent"></div>
        </div>

        <!-- Recent Donations Table -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <h6 class="text-lg font-semibold mb-4">Recent Non-Monetary Donations</h6>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentDonations as $donation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donation->item_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donation->item_category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($donation->item_quantity) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donation->donor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donation->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $donation->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Monthly Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Non-Monetary Donations',
                    data: @json($monthlyData),
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(@json($categoryData)),
                datasets: [{
                    data: Object.values(@json($categoryData)),
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Summary function
        function showSummary(type) {
            const content = document.getElementById('summaryContent');
            const labels = type === 'monthly' ? @json($monthlyLabels) : @json($annualLabels);
            const data = type === 'monthly' ? @json($monthlyData) : @json($annualData);
            
            let html = `
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
            `;

            labels.forEach((label, index) => {
                html += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${label}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${number_format(data[index])}</td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>
            `;

            content.innerHTML = html;
        }

        // Helper function to format numbers
        function number_format(number, decimals = 0) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            }).format(number);
        }

        // Show monthly summary by default
        showSummary('monthly');
    </script>
@endsection