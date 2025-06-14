@extends('components.admin-layout')

@section('content')
<div class="container">
    <div class="mb-8 flex justify-content-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Urgent Campaigns</h1>
            <p class="text-sm text-gray-600 mt-1">Manage and track all urgent campaigns</p>
        </div>
        <a href="{{ route('admin.urgent-campaigns.create') }}" class="btn btn-primary">New Urgent Campaign</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="urgent-campaigns-table" class="table">
        <thead>
            <tr>
                <th style="width: 150px;">Title</th>
                <th style="width: 250px;">Description</th>
                <th>Goal</th>
                <th>Current</th>
                <th>Active</th>
                <th>Ends At</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($urgentCampaigns as $campaign)
                <tr>
                    <td class="text-truncate" style="max-width: 150px;">{{ $campaign->title }}</td>
                    <td class="text-truncate" style="max-width: 250px;">{{ $campaign->description }}</td>
                    <td>₱{{ number_format($campaign->goal_amount, 2) }}</td>
                    <td>₱{{ number_format($campaign->current_amount, 2) }}</td>
                    <td>{{ $campaign->is_active ? 'Yes' : 'No' }}</td>
                    <td>{{ $campaign->ends_at ? $campaign->ends_at->format('M d, Y h:i A') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.urgent-campaigns.show', $campaign->id) }}" class="btn btn-sm btn-info mb-1"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.urgent-campaigns.edit', $campaign->id) }}" class="btn btn-sm btn-warning mb-1"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-campaign-id="{{ $campaign->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this urgent campaign?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteCampaignForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    deleteConfirmationModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const campaignId = button.getAttribute('data-campaign-id');
        const deleteForm = document.getElementById('deleteCampaignForm');
        deleteForm.action = `{{ route('admin.urgent-campaigns.destroy', ['urgent_campaign' => 'TEMP_ID']) }}`.replace('TEMP_ID', campaignId);
    });
</script>
@endpush 