@extends('components.admin-layout')

@section('content')
<div class="p-8 bg-[#f3f6fb] min-h-screen">
    <div class="mb-8 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold">All Donations </h1>
        <p class="text-sm text-gray-600 mt-1">Review and manage all donations.</p>
      </div>
        <div class="flex items-center space-x-2">
            <span class="text-gray-600">Admin</span>
            <div class="bg-blue-200 text-blue-700 rounded-full px-3 py-1 font-semibold">AD</div>
        </div>
    </div>
    
    <a href="{{ route('admin.donations.index') }}" class="inline-flex items-center px-4 py-2 mb-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
    </a>

    <!-- All Donations Table -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">All Donations</h2>
            <div class="flex items-center space-x-4">
                <form action="{{ route('admin.donations.all-donors') }}" method="GET" class="flex-grow">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" name="search_donations" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search donations..." value="{{ request('search_donations') }}" />
                    </div>
                </form>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.donations.all-donors', array_merge(request()->query(), ['filter' => 'all'])) }}" class="px-4 py-2 rounded-lg text-sm {{ request('filter', 'all') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        All
                    </a>
                    <a href="{{ route('admin.donations.all-donors', array_merge(request()->query(), ['filter' => 'monetary'])) }}" class="px-4 py-2 rounded-lg text-sm {{ request('filter') == 'monetary' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Monetary
                    </a>
                    <a href="{{ route('admin.donations.all-donors', array_merge(request()->query(), ['filter' => 'non-monetary'])) }}" class="px-4 py-2 rounded-lg text-sm {{ request('filter') == 'non-monetary' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Non-Monetary
                    </a>
                    <a href="{{ route('admin.donations.all-donors', array_merge(request()->query(), ['filter' => 'campaigns'])) }}" class="px-4 py-2 rounded-lg text-sm {{ request('filter') == 'campaigns' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Campaigns
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 text-left">Donor</th>
                        <th class="py-2 text-left">Type</th>
                        <th class="py-2 text-left">Amount</th>
                        <th class="py-2 text-left">Status</th>
                        <th class="py-2 text-left">Date</th>
                        <th class="py-2 text-left">Proof</th>
                        <th class="py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                    <tr class="border-b">
                        <td class="py-2 flex items-center space-x-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($donation->donor_name) }}&background=random" class="w-8 h-8 rounded-full" alt="{{ $donation->donor_name }}">
                            <span>
                                <div class="font-semibold">{{ $donation->donor_name }}</div>
                                <div class="text-xs text-gray-500">{{ $donation->donor_email }}</div>
                            </span>
                        </td>
                        <td class="py-2">{{ ucfirst($donation->type) }}</td>
                        <td class="py-2 font-bold">
                            @if($donation->type === 'monetary')
                                ₱{{ number_format($donation->amount, 2) }}
                            @else
                                {{ $donation->item_name }}
                            @endif
                        </td>
                        <td class="py-2">
                            <span class="bg-{{ $donation->status === 'completed' ? 'green' : 'yellow' }}-100 text-{{ $donation->status === 'completed' ? 'green' : 'yellow' }}-600 px-2 py-1 rounded">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td class="py-2">{{ $donation->created_at->format('M d, Y') }}</td>
                        <td class="py-2">
                            @if($donation->proof_path)
                                <img src="{{ Storage::url($donation->proof_path) }}" alt="Donation Proof" class="w-10 h-10 object-cover rounded">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-2">
                            <div class="flex space-x-2">
                                 <a href="{{ route('admin.donations.show', $donation) }}" class="text-green-800 bg-green-100 px-2 py-1 rounded hover:bg-green-200"><i class="fas fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Proof Image Modal -->
    <div id="proofModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-4 max-w-lg max-h-full overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h3 class="text-lg font-semibold">Donation Proof</h3>
                <button id="closeProofModal" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <img id="proofImage" src="" alt="Donation Proof" class="max-w-full h-auto">
        </div>
    </div>

    @push('styles')
    <style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
    }

    .dropdown-item i {
        width: 1.25rem;
    }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Proof image modal functionality
        const proofModal = document.getElementById('proofModal');
        const proofImage = document.getElementById('proofImage');
        const closeProofModal = document.getElementById('closeProofModal');
        const viewProofLinks = document.querySelectorAll('.view-proof-link');

        viewProofLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const imageUrl = this.dataset.proofUrl;
                proofImage.src = imageUrl;
                proofModal.classList.remove('hidden');
            });
        });

        closeProofModal.addEventListener('click', function() {
            proofModal.classList.add('hidden');
            proofImage.src = ''; // Clear the image source when closing
        });

        // Close modal when clicking outside of the modal content
        proofModal.addEventListener('click', function(e) {
            if (e.target === proofModal) {
                proofModal.classList.add('hidden');
                proofImage.src = ''; // Clear the image source when closing
            }
        });
    });
    </script>
    @endpush
</div>
@endsection 