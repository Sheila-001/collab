@extends('components.admin-layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Urgent Campaign Details</h1>
            <p class="text-sm text-gray-600 mt-1">View the full details of the urgent campaign.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.urgent-campaigns.index') }}" class="btn btn-secondary">Back to List</a>
            <a href="{{ route('admin.urgent-campaigns.edit', $urgentCampaign->id) }}" class="btn btn-warning">Edit Campaign</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-4">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $urgentCampaign->title }}</h2>
        <div class="space-y-3">
            <p class="text-gray-700"><strong>Description:</strong> {{ $urgentCampaign->description }}</p>
            <p class="text-gray-700"><strong>Goal Amount:</strong> ₱{{ number_format($urgentCampaign->goal_amount, 2) }}</p>
            <p class="text-gray-700"><strong>Current Amount:</strong> ₱{{ number_format($urgentCampaign->current_amount, 2) }}</p>
            <p class="text-gray-700"><strong>Active:</strong> {{ $urgentCampaign->is_active ? 'Yes' : 'No' }}</p>
            <p class="text-gray-700"><strong>Ends At:</strong> {{ $urgentCampaign->ends_at ? $urgentCampaign->ends_at->format('M d, Y h:i A') : 'N/A' }}</p>
            <p class="text-gray-700"><strong>Created At:</strong> {{ $urgentCampaign->created_at->format('M d, Y h:i A') }}</p>
            <p class="text-gray-700"><strong>Last Updated:</strong> {{ $urgentCampaign->updated_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>

</div>
@endsection 