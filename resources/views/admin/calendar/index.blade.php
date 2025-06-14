@extends('components.admin-layout')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Campaign Calendar</h1>
                <p class="text-sm text-gray-600">View and manage scheduled campaigns</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.calendar-categories.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Manage Categories
                </a>
                <a href="{{ route('admin.calendar-campaigns.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-[#1B4B5A] text-white rounded-md hover:bg-[#2C5F6E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Schedule New Campaign
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <svg class="h-4 w-4 fill-current" role="button" viewBox="0 0 20 20">
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Calendar Legend -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Categories</h3>
                        <a href="{{ route('admin.calendar-categories.create') }}"
                           class="inline-flex items-center justify-center w-6 h-6 text-sm bg-[#1B4B5A] text-white rounded-full hover:bg-[#2C5F6E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                            +
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($categories as $category)
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded mr-2" style="background-color: {{ $category->color }}"></div>
                                <span class="text-sm text-gray-600">{{ $category->name }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No categories found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($campaigns),
                eventClick: function(info) {
                    // Handle event click - you can add a modal or redirect to event details
                },
                eventDidMount: function(info) {
                    // Add tooltips
                    info.el.title = `${info.event.title}\nCategory: ${info.event.extendedProps.category}\nStatus: ${info.event.extendedProps.status}`;
                },
                eventContent: function(arg) {
                    // Get the background color from the className (which includes the color)
                    const colorMatch = arg.event.classNames[0].match(/bg-\[(.*?)\]/);
                    const backgroundColor = colorMatch ? colorMatch[1] : '#000000';
                    
                    // Create a wrapper div that will be fully colored
                    const wrapper = document.createElement('div');
                    wrapper.className = 'event-wrapper';
                    wrapper.style.backgroundColor = backgroundColor;
                    wrapper.style.height = '100%';
                    wrapper.style.width = '100%';
                    wrapper.style.borderRadius = '4px';
                    wrapper.style.padding = '4px 8px';
                    
                    // Add the title
                    const title = document.createElement('div');
                    title.className = 'event-title';
                    title.textContent = arg.event.title;
                    title.style.color = 'white';
                    title.style.fontWeight = '500';
                    title.style.textShadow = '0 1px 2px rgba(0, 0, 0, 0.2)';
                    
                    wrapper.appendChild(title);
                    
                    return { domNodes: [wrapper] };
                }
            });
            calendar.render();
        });
    </script>
    <style>
        /* Calendar container styles */
        .fc {
            background: white;
        }
        
        /* Event styles */
        .fc-event {
            margin: 2px !important;
            border: none !important;
        }
        
        .fc-h-event {
            background: none !important;
            border: none !important;
        }
        
        .fc-daygrid-event {
            white-space: normal !important;
            align-items: normal !important;
            margin-top: 2px !important;
            margin-bottom: 2px !important;
        }
        
        /* Event wrapper styles */
        .event-wrapper {
            min-height: 24px;
            display: flex;
            align-items: center;
        }
        
        /* Make events take full width in their cell */
        .fc .fc-daygrid-event-harness {
            width: calc(100% - 4px) !important;
            margin-left: 2px !important;
            margin-right: 2px !important;
        }
        
        /* Ensure event content takes full width */
        .fc-event-main {
            flex: 1;
            width: 100%;
        }
        
        /* Title styles */
        .event-title {
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.875rem;
            line-height: 1.25;
        }
    </style>
    @endpush
@endsection 