<x-app-layout>
    <div class="flex">
        <!-- Sidebar (reuse from your other pages) -->
        <div class="w-64 min-h-screen bg-[#1B4B5A] text-white">
            <div class="p-4 flex items-center space-x-2">
                <img src="{{ asset('image/logohauzhayag.jpg') }}" alt="Hauz Hayag Logo" class="h-16 w-auto rounded-lg shadow-md">
                <h1 class="text-2xl font-bold">Hauz Hayag</h1>
            </div>
            <nav class="mt-8">
                <a href="/dashboard" class="flex items-center px-4 py-3 bg-[#2C5F6E] hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="/users" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    User Management
                </a>
                <a href="/events" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Events
                </a>
                <a href="/students" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Students
                </a>
                <a href="{{ route('admin.volunteers.index') }}" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Volunteers
                    </a>
                <a href="{{ route('jobs.listings') }}" class="flex items-center px-4 py-3 bg-[#2C5F6E] hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Jobs
                </a>
                <div class="mt-auto pt-20">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors text-red-300 hover:text-red-200">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-50">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Available Jobs</h1>
            <form method="GET" action="" class="mb-6 flex flex-wrap gap-3 items-end">
                <input type="text" name="search" placeholder="Search jobs..." value="{{ request('search') }}" class="border border-gray-300 rounded px-3 py-2 w-64">
                <select name="company" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">All Companies</option>
                    @foreach($companies ?? [] as $company)
                        <option value="{{ $company }}" @if(request('company') == $company) selected @endif>{{ $company }}</option>
                    @endforeach
                </select>
                <select name="location" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">All Locations</option>
                    @foreach($locations ?? [] as $location)
                        <option value="{{ $location }}" @if(request('location') == $location) selected @endif>{{ $location }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-secondary text-white px-4 py-2 rounded hover:bg-secondary/80 transition">Filter</button>
            </form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($jobs as $job)
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-primary mb-2">{{ $job->title }}</h2>
                            <p class="text-gray-700 mb-2"><span class="font-semibold">Company:</span> {{ $job->company }}</p>
                            <p class="text-gray-700 mb-2"><span class="font-semibold">Location:</span> {{ $job->location }}</p>
                            @if($job->salary)
                                <p class="text-gray-700 mb-2"><span class="font-semibold">Salary:</span> {{ $job->salary }}</p>
                            @endif
                            <p class="text-gray-600 mt-2">{{ Str::limit($job->description, 100) }}</p>
                        </div>
                        <div class="mt-4">
                            <button onclick="showJobDetails({{ $job->id }})" class="bg-secondary text-white px-4 py-2 rounded hover:bg-secondary/80 transition">View Details</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">No jobs available at the moment.</div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
            <!-- Job Details Modal (hidden by default) -->
            <div id="job-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg w-full relative">
                    <button onclick="closeJobModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
                    <div id="job-modal-content">
                        <!-- Job details will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showJobDetails(jobId) {
            fetch(`/api/job-listings/${jobId}`)
                .then(response => response.json())
                .then(job => {
                    document.getElementById('job-modal-content').innerHTML = `
                        <h2 class='text-xl font-bold text-primary mb-2'>${job.title}</h2>
                        <p class='mb-2'><span class='font-semibold'>Company:</span> ${job.company}</p>
                        <p class='mb-2'><span class='font-semibold'>Location:</span> ${job.location}</p>
                        ${job.salary ? `<p class='mb-2'><span class='font-semibold'>Salary:</span> ${job.salary}</p>` : ''}
                        <p class='mb-2'><span class='font-semibold'>Description:</span> ${job.description}</p>
                        ${job.requirements ? `<p class='mb-2'><span class='font-semibold'>Requirements:</span> ${job.requirements}</p>` : ''}
                    `;
                    document.getElementById('job-modal').classList.remove('hidden');
                });
        }
        function closeJobModal() {
            document.getElementById('job-modal').classList.add('hidden');
        }
    </script>
</x-app-layout> 