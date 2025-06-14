@extends('components.admin-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <!-- Main Content -->
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h5 class="card-title mb-0">Donation Details</h5>
                    <div>
                        <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Proof/Image Display - Moved to left column --}}
                        <div class="col-md-6 border-end pr-md-4">
                            @if($donation->proof_path || $donation->image_path)
                            <h6 class="text-muted mb-3 border-bottom pb-2">{{ $donation->type === 'monetary' ? 'Donation Proof' : 'Item Image' }}</h6>
                            <div class="text-center mb-4">
                                @if($donation->proof_path)
                                    <img src="{{ Storage::url($donation->proof_path) }}" alt="Donation Proof" class="img-fluid rounded max-h-96 mx-auto border shadow-sm">
                                @elseif($donation->image_path)
                                    <img src="{{ Storage::url($donation->image_path) }}" alt="Item Image" class="img-fluid rounded max-h-96 mx-auto border shadow-sm">
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6 pl-md-4">
                            <h6 class="text-muted mb-3 border-bottom pb-2">Donor Information</h6>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Name</label>
                                <p class="mb-0">{{ $donation->donor_name }}</p>
                            </div>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Email</label>
                                <p class="mb-0">{{ $donation->donor_email }}</p>
                            </div>
                            {{-- Assuming phone number exists in donation model based on image --}}
                            @if($donation->donor_phone ?? false)
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Phone</label>
                                <p class="mb-0">{{ $donation->donor_phone }}</p>
                            </div>
                            @endif

                            <h6 class="text-muted mb-3 mt-4 border-bottom pb-2">Donation Information</h6>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Type</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $donation->type === 'monetary' ? 'primary' : 'success' }}">
                                        {{ ucfirst($donation->type) }}
                                    </span>
                                </p>
                            </div>
                            @if($donation->type === 'monetary')
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Amount</label>
                                <p class="mb-0">₱{{ number_format($donation->amount, 2) }}</p>
                            </div>
                            {{-- Add Payment Method for Monetary --}}
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Payment Method</label>
                                <p class="mb-0">{{ ucfirst($donation->payment_method) }}</p>
                            </div>
                            @else
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Expected Drop-off Date</label>
                                <p class="mb-0">{{ $donation->expected_date?->format('M d, Y h:i A') ?? 'N/A' }}</p>
                            </div>
                            {{-- Display Contact Number for non-monetary --}}
                            @if($donation->donor_phone)
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Contact Number</label>
                                <p class="mb-0">{{ $donation->donor_phone }}</p>
                            </div>
                            @endif
                            {{-- Display Notes for non-monetary --}}
                            @if($donation->notes)
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Note</label>
                                <p class="mb-0">{{ $donation->notes }}</p>
                            </div>
                            @endif
                            {{-- Display Category for non-monetary --}}
                            @if($donation->category)
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Category</label>
                                <p class="mb-0">{{ $donation->category }}</p>
                            </div>
                            @endif
                            {{-- Display Item Condition for non-monetary --}}
                            @if($donation->condition)
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Item Condition</label>
                                <p class="mb-0">{{ $donation->condition }}</p>
                            </div>
                            @endif
                            @endif
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $donation->status === 'completed' ? 'success' : ($donation->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </p>
                            </div>
                            {{-- Display Acknowledged Status --}}
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Acknowledged</label>
                                <p class="mb-0">{{ $donation->is_acknowledged ? 'Yes' : 'No' }}</p>
                            </div>
                            {{-- Display Anonymous Status --}}
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Anonymous</label>
                                <p class="mb-0">{{ $donation->is_anonymous ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Status Update Form --}}
                    @if($donation->status === 'pending')
                        <div class="row mt-4 border-top pt-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3 border-bottom pb-2">Update Status</h6>
                                <form action="{{ route('admin.donations.update-status', $donation->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="status">
                                            <option value="completed">Mark as Confirmed</option>
                                            <option value="rejected">Mark as Rejected</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Additional Notes - Keeping if they exist, outside the two columns --}}
                    @if($donation->notes)
                    <div class="row mt-4 border-top pt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 border-bottom pb-2">Additional Notes</h6>
                            <div class="card bg-light shadow-sm">
                                <div class="card-body">
                                    {{ $donation->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Add any specific styles needed for this page */
.max-h-96 {
    max-height: 24rem;
}
</style>
@endpush

@push('scripts')
<script>
// Add any specific scripts needed for this page
</script>
@endpush 