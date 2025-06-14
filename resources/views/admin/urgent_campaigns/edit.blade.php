@extends('components.admin-layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Urgent Campaign</h1>
            <p class="text-sm text-gray-600 mt-1">Update the details of the urgent campaign.</p>
        </div>
        <a href="{{ route('admin.urgent-campaigns.show', $urgentCampaign->id) }}" class="btn btn-secondary">Back to Details</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.urgent-campaigns.update', $urgentCampaign->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $urgentCampaign->title) }}" required>
            </div>
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $urgentCampaign->description) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="goal_amount" class="form-label">Goal Amount</label>
                <input type="number" class="form-control" id="goal_amount" name="goal_amount" step="0.01" value="{{ old('goal_amount', $urgentCampaign->goal_amount) }}" required>
            </div>
            <div class="mb-4">
                <label for="ends_at" class="form-label">Ends At (Optional)</label>
                <input type="datetime-local" class="form-control" id="ends_at" name="ends_at" value="{{ old('ends_at', $urgentCampaign->ends_at ? $urgentCampaign->ends_at->format('Y-m-d\\TH:i') : '') }}">
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $urgentCampaign->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Update Campaign</button>
            </div>
        </form>
    </div>
</div>
@endsection 