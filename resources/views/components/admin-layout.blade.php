<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        #urgent-campaigns-table th {
            font-weight: normal;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <div class="w-64 bg-[#1B4B5A] text-white flex flex-col fixed h-full">
            <div class="p-4 flex items-center space-x-2">
                <img src="{{ asset('image/logohauzhayag.jpg') }}"
                     alt="Hauz Hayag Logo"
                     class="h-16 w-auto rounded-lg shadow-md">
                <h1 class="text-2xl font-bold">Hauz Hayag</h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('admin.donations.index') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <i class="fas fa-calendar mr-3"></i>
                    Events
                </a>
                <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <i class="fas fa-user-graduate mr-3"></i>
                    Applicants
                </a>
                <a href="{{ route('admin.volunteers.index') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <i class="fas fa-hands-helping mr-3"></i>
                    Volunteers
                </a>
                <a href="{{ route('admin.jobs.index') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <i class="fas fa-briefcase mr-3"></i>
                    Jobs
                </a>
                
                {{-- Donations parent link --}}
                <a href="#" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors" onclick="toggleDonationsSubmenu(event)">
                    <i class="fas fa-hand-holding-heart mr-3"></i>
                    <span>Donations</span>
                    <svg class="w-4 h-4 ml-auto transform transition-transform" id="donationsArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>

                {{-- Donations submenu --}}
                <div id="donationsSubmenu" class="pl-4 hidden">
                    <a href="{{ route('admin.donations.index') }}" class="flex items-center px-4 py-2 hover:bg-[#2C5F6E] transition-colors text-sm">
                        <i class="fas fa-list-alt mr-2"></i>
                        All Donations
                    </a>
                    <a href="{{ route('admin.campaigns.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-[#2C5F6E] transition-colors text-sm">
                        <i class="fas fa-bullhorn mr-2"></i>
                        Campaigns
                    </a>
                    <a href="{{ route('admin.urgent-campaigns.index') }}" class="flex items-center px-4 py-2 hover:bg-[#2C5F6E] transition-colors text-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Urgent Campaigns
                    </a>
                    <a href="{{ route('admin.calendar.index') }}" class="flex items-center px-4 py-2 hover:bg-[#2C5F6E] transition-colors text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Calendar
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 hover:bg-[#2C5F6E] transition-colors text-sm">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Donation Reports
                    </a>
                </div>

                <div class="mt-auto pt-20">
                    <a href="{{ route('admin.logout') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors text-red-300 hover:text-red-200">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </a>
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 bg-gray-100 ml-64 overflow-y-auto h-screen p-6">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDonationsSubmenu(event) {
            event.preventDefault();
            const submenu = document.getElementById('donationsSubmenu');
            const arrow = document.getElementById('donationsArrow');
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
    @stack('scripts')
</body>
</html> 