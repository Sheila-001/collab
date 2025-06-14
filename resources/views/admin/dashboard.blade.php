@extends('components.admin-layout')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header Row: Title and User Badge -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Dashboard Overview</h1>
            <div class="flex items-center gap-2">
                <span class="text-gray-500">Admin</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold">AD</span>
            </div>
        </div>

        <!-- Statistic Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Monetary Donations</span>
                <span id="monetaryTotal" class="text-3xl font-bold mt-2">₱{{ number_format($monetaryTotal, 2) }}</span>
                @if($monetaryChange != 0)
                    <span id="monetaryChange" class="text-sm {{ $monetaryChange > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        {{ $monetaryChange > 0 ? '+' : '' }}{{ number_format($monetaryChange, 1) }}%
                    </span>
                @else
                    <span id="monetaryChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Non-Monetary Donations</span>
                <span id="nonMonetaryCount" class="text-3xl font-bold mt-2">{{ $nonMonetaryCount }}</span>
                @if($nonMonetaryChange != 0)
                    <span id="nonMonetaryChange" class="text-sm {{ $nonMonetaryChange > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        {{ $nonMonetaryChange > 0 ? '+' : '' }}{{ number_format($nonMonetaryChange, 1) }}%
                    </span>
                @else
                    <span id="nonMonetaryChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Campaign Donations</span>
                <span id="campaignTotal" class="text-3xl font-bold mt-2">₱{{ number_format($campaignTotal, 2) }}</span>
                @if($campaignChange != 0)
                    <span id="campaignChange" class="text-sm {{ $campaignChange > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        {{ $campaignChange > 0 ? '+' : '' }}{{ number_format($campaignChange, 1) }}%
                    </span>
                @else
                    <span id="campaignChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Total Donors</span>
                <span id="donorCount" class="text-3xl font-bold mt-2">{{ $donorCount }}</span>
                @if($donorChange != 0)
                    <span id="donorChange" class="text-sm {{ $donorChange > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        {{ $donorChange > 0 ? '+' : '' }}{{ number_format($donorChange, 1) }}%
                    </span>
                @else
                    <span id="donorChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Pending Donations</span>
                <span id="pendingDonations" class="text-3xl font-bold mt-2">{{ $pendingDonations }}</span>
                <span class="text-sm text-yellow-600 mt-1">Awaiting confirmation</span>
            </div>
        </div>

        <!-- Recent Donations and Pending Drop-offs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Donations -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg">Recent Donations</h2>
                    <a href="{{ route('admin.donations.index') }}" class="text-blue-600 hover:underline">View all</a>
                </div>
                @if($donations->count() > 0)
                    <div class="space-y-4">
                        @foreach($donations as $donation)
                            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold">{{ $donation->donor_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $donation->type === 'monetary' ? '₱' . number_format($donation->amount, 2) : 'Non-monetary' }}</p>
                                    </div>
                                    <span class="px-2 py-1 rounded text-sm {{ $donation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $donation->created_at->format('M d, Y H:i A') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No recent donations found.</p>
                @endif
            </div>

            <!-- Pending Drop-offs -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg">Pending Drop-offs</h2>
                    <a href="{{ route('admin.donations.dropoffs') }}" class="text-blue-600 hover:underline">View all</a>
                </div>
                @if($pendingDropoffs->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingDropoffs as $dropoff)
                            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                <p class="font-semibold">{{ $dropoff->donor_name }}</p>
                                <p class="text-sm text-gray-500">{{ $dropoff->description }}</p>
                                <p class="text-sm text-gray-500 mt-1">Expected: {{ $dropoff->dropoff_date ? $dropoff->dropoff_date->format('M d, Y') : 'Not specified' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No pending drop-offs.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    console.log("Dashboard update script is running!");

    function updateDonationStats() {
        fetch('/api/admin/donation-stats', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('monetaryTotal').textContent = `₱${data.monetaryTotal}`;
            updateChangeSpan('monetaryChange', data.monetaryChange);

            document.getElementById('nonMonetaryCount').textContent = data.nonMonetaryCount;
            updateChangeSpan('nonMonetaryChange', data.nonMonetaryChange);

            document.getElementById('campaignTotal').textContent = `₱${data.monetaryTotal}`;
            updateChangeSpan('campaignChange', data.monetaryChange);

            document.getElementById('donorCount').textContent = data.donorCount;
            updateChangeSpan('donorChange', data.donorChange);

            document.getElementById('pendingDonations').textContent = data.pendingDonations;
        })
        .catch(error => console.error('Error fetching donation stats:', error));
    }

    function updateChangeSpan(id, changeValue) {
        const span = document.getElementById(id);
        if (span) {
            span.textContent = `${changeValue > 0 ? '+' : ''}${changeValue}%`;
            span.classList.remove('text-green-500', 'text-red-500', 'text-gray-500');
            if (changeValue > 0) {
                span.classList.add('text-green-500');
            } else if (changeValue < 0) {
                span.classList.add('text-red-500');
            } else {
                span.classList.add('text-gray-500');
            }
        }
    }

    // Update every 5 seconds
    setInterval(updateDonationStats, 5000);

    // Initial load
    document.addEventListener('DOMContentLoaded', updateDonationStats);
</script>
@endpush