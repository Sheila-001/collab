@extends('components.admin-layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4">Campaigns Report</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-gray-600 mb-1">Total Campaigns</div>
                    <div class="text-xl font-semibold text-gray-800">{{ number_format($totalCampaigns) }}</div>
                </div>
                <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-gray-600 mb-1">Total Donations</div>
                    <div class="text-xl font-semibold text-gray-800">{{ number_format($totalDonations) }}</div>
                </div>
                <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-gray-600 mb-1">Total Amount</div>
                    <div class="text-xl font-semibold text-gray-800">₱{{ number_format($totalAmount, 2) }}</div>
                </div>
                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h6 class="text-lg font-semibold mb-4">Campaign Performance</h6>
            <canvas id="campaignPerformanceChart"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h6 class="text-lg font-semibold mb-4">Campaign Status Distribution</h6>
            <canvas id="campaignStatusChart"></canvas>
        </div>
    </div>

    <!-- Campaigns Table -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h6 class="text-lg font-semibold mb-4">Campaign Overview</h6>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donations</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($campaigns as $campaign)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $campaign->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $campaign->start_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $campaign->end_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                                    'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($campaign->donations_count) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($campaign->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Campaign Performance Chart
    new Chart(document.getElementById('campaignPerformanceChart'), {
        type: 'bar',
        data: {
            labels: @json($campaignLabels),
            datasets: [{
                label: 'Donations',
                data: @json($campaignDonations),
                backgroundColor: 'rgb(54, 162, 235)'
            }, {
                label: 'Amount',
                data: @json($campaignAmounts),
                backgroundColor: 'rgb(75, 192, 192)',
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Number of Donations'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Amount (₱)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Campaign Status Chart
    new Chart(document.getElementById('campaignStatusChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(@json($campaignStatusData)),
            datasets: [{
                data: Object.values(@json($campaignStatusData)),
                backgroundColor: [
                    'rgb(34, 197, 94)',  // green for active
                    'rgb(59, 130, 246)', // blue for completed
                    'rgb(156, 163, 175)' // gray for others
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
@endpush
@endsection 