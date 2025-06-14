@extends('components.admin-layout')

@section('content')
    {{-- Add Chart.js library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container-fluid px-4">
        <h1 class="h3 mb-4">Donors Report</h1>

        <!-- Summary Card -->
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-gray-600 mb-1">Total Unique Donors</div>
                        <div class="text-xl font-semibold text-gray-800">{{ number_format($totalDonors) }}</div>
                    </div>
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h6 class="text-lg font-semibold mb-4">Monthly Donors</h6>
                <canvas id="monthlyChart"></canvas>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h6 class="text-lg font-semibold mb-4">Donor Types</h6>
                <canvas id="donorTypeChart"></canvas>
            </div>
        </div>

        <!-- Top Donors Tables -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <!-- Top Donors by Amount -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h6 class="text-lg font-semibold mb-4">Top Donors by Amount</h6>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topDonorsByAmount as $donor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donor->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($donor->total_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Donors by Frequency -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h6 class="text-lg font-semibold mb-4">Top Donors by Frequency</h6>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donation Count</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topDonorsByFrequency as $donor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donor->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($donor->donation_count) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Donors Table -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h6 class="text-lg font-semibold mb-4">Recent Donors</h6>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donations</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Donation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentDonors as $donor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donor->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($donor->type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($donor->donation_count) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donor->last_donation_date?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $donor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($donor->status) }}
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
                    label: 'Monthly Donors',
                    data: @json($monthlyData),
                    borderColor: 'rgb(75, 192, 192)',
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

        // Donor Type Chart
        new Chart(document.getElementById('donorTypeChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(@json($donorTypeData)),
                datasets: [{
                    data: Object.values(@json($donorTypeData)),
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
    </script>
@endsection