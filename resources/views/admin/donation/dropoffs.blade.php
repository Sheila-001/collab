@extends('components.admin-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Drop-Off Donations</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
    <p class="text-muted mb-4">Manage and track non-monetary donations</p>

    <ul class="nav nav-tabs mb-4" id="donationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                Pending Drop-offs <span class="badge bg-warning ms-1">{{ $pendingDropoffs->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                Completed Drop-offs <span class="badge bg-success ms-1">{{ $completedDropoffs->count() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Pending Drop-offs -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Drop-Off Confirmation</h5>
                    <a href="{{ route('admin.donations.dropoffs') }}" class="btn btn-primary btn-sm">
                        Manage Drop-Offs
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-4">Item</th>
                                    <th class="py-3 px-4">Donor</th>
                                    <th class="py-3 px-4">Campaign</th>
                                    <th class="py-3 px-4">Expected Drop-off Date</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="text-end py-3 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingDropoffs as $dropoff)
                                <tr>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-box text-info"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="fw-medium">{{ $dropoff->item_description }}</div>
                                                <div class="small text-muted">{{ $dropoff->quantity }} units</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ $dropoff->donor->avatar_url ?? asset('images/default-avatar.png') }}" 
                                                     class="rounded-circle" alt="Avatar">
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $dropoff->donor_name }}</div>
                                                <div class="small text-muted">{{ $dropoff->donor_email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($dropoff->campaign)
                                            <span class="badge bg-info">{{ $dropoff->campaign->title }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $dropoff->expected_date?->format('M d, Y g:i A') ?? 'Not specified' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td class="text-end py-3 px-4">
                                        <div class="btn-group">
                                            <button class="btn btn-success btn-sm me-2" 
                                                    onclick="updateDropoffStatus('{{ $dropoff->id }}', 'completed')">
                                                <i class="fas fa-check me-1"></i> Confirm Receipt
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="updateDropoffStatus('{{ $dropoff->id }}', 'cancelled')">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">No pending drop-offs</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if($pendingDropoffs->hasPages())
                <div class="card-footer bg-white border-0">
                    {{ $pendingDropoffs->links() }}
                </div>
                @endif --}}
            </div>
        </div>

        <!-- Completed Drop-offs -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-4">Item Details</th>
                                    <th class="py-3 px-4">Donor</th>
                                    <th class="py-3 px-4">Campaign</th>
                                    <th class="py-3 px-4">Received Date</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="text-end py-3 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($completedDropoffs as $dropoff)
                                <tr>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-box text-success"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="fw-medium">{{ $dropoff->item_description }}</div>
                                                <div class="small text-muted">{{ $dropoff->quantity }} units</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ $dropoff->donor->avatar_url ?? asset('images/default-avatar.png') }}" 
                                                     class="rounded-circle" alt="Avatar">
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $dropoff->donor_name }}</div>
                                                <div class="small text-muted">{{ $dropoff->donor_email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($dropoff->campaign)
                                            <span class="badge bg-info">{{ $dropoff->campaign->title }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $dropoff->updated_at?->format('M d, Y g:i A') ?? 'Not available' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-success">Completed</span>
                                    </td>
                                    <td class="text-end py-3 px-4">
                                        <a href="{{ route('admin.donations.show', $dropoff) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">No completed drop-offs</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if($completedDropoffs->hasPages())
                <div class="card-footer bg-white border-0">
                    {{ $completedDropoffs->links() }}
                </div>
                @endif --}}
            </div>
        </div>
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
function updateDropoffStatus(id, status) {
    fetch(`/admin/donations/${id}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating status.');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var donationTabs = new bootstrap.Tab(document.getElementById('pending-tab'));
    donationTabs.show();
});
</script>
@endpush
@endsection