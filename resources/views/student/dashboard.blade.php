@extends('components.admin-layout')

@section('title', 'Student Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600">Stay updated with our latest campaigns and make a difference today.</p>
    </div>

    <!-- Active Campaigns Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Active Campaigns</h2>
            <a href="{{ route('user.calendar') }}" class="text-blue-600 hover:text-blue-800">View Calendar</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($campaigns ?? [] as $campaign)
                <div class="border border-gray-200 rounded-lg p-4">
                    @if($campaign->image)
                        <img src="{{ Storage::url($campaign->image) }}" 
                             alt="{{ $campaign->title }}" 
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $campaign->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($campaign->description, 100) }}</p>
                    
                    <div class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            @php
                                $progress = ($campaign->goal_amount > 0) ? min(($campaign->funds_raised / $campaign->goal_amount) * 100, 100) : 0;
                            @endphp
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                            <span>₱{{ number_format($campaign->funds_raised, 2) }} raised</span>
                            <span>{{ number_format($progress) }}%</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            {{ $campaign->end_date ? $campaign->end_date->diffForHumans() : 'No end date' }}
                        </span>
                        <a href="{{ route('monetary_donation') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                            Donate Now
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No active campaigns at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('events.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Events</h3>
            <p class="text-gray-600">View and join upcoming events</p>
        </a>
        
        <a href="{{ route('jobs.listings') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Job Listings</h3>
            <p class="text-gray-600">Explore career opportunities</p>
        </a>
        
        <a href="{{ route('scholarship.track') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Scholarship Status</h3>
            <p class="text-gray-600">Track your scholarship application</p>
        </a>
    </div>
</div>
@endsection 