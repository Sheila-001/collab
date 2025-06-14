<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2C5F6E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar Navigation -->
        <div class="w-64 min-h-screen bg-[#1B4B5A] text-white">
            <div class="p-4 flex items-center space-x-2">
                <img src="{{ asset('image/logohauzhayag.jpg') }}" alt="Hauz Hayag Logo" class="h-16 w-auto rounded-lg shadow-md">
                <h1 class="text-2xl font-bold">Hauz Hayag</h1>
            </div>
            <nav class="mt-8">
                <a href="/student/dashboard" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="/student/scholarship" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Scholarship
                </a>
                <a href="/student/jobs" class="flex items-center px-4 py-3 bg-[#2C5F6E]">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Job Listings
                </a>
                <a href="/student/events" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Events
                </a>
                <div class="mt-auto pt-20">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors text-red-300 hover:text-red-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-gray-50">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Job Listings</h1>
                <p class="text-gray-600">Find and apply for job opportunities</p>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" placeholder="Search jobs..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="flex gap-4">
                        <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>All Categories</option>
                            <option>Technology</option>
                            <option>Business</option>
                            <option>Education</option>
                        </select>
                        <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>All Types</option>
                            <option>Full-time</option>
                            <option>Part-time</option>
                            <option>Internship</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="space-y-4">
                <!-- Job Card 1 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Software Developer Intern</h3>
                            <p class="text-sm text-gray-600 mt-1">Tech Solutions Inc.</p>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Technology</span>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Internship</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Duration: 3 months</p>
                            <p class="text-sm text-gray-600">Location: Remote</p>
                            <p class="text-sm text-gray-600 mt-2">Salary: $15-20/hour</p>
                            <p class="text-sm text-gray-600">Posted: March 1, 2024</p>
                        </div>
                        <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                            Apply Now
                        </button>
                    </div>
                </div>

                <!-- Job Card 2 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Marketing Assistant</h3>
                            <p class="text-sm text-gray-600 mt-1">Global Marketing Co.</p>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Marketing</span>
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Part-time</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Duration: 6 months</p>
                            <p class="text-sm text-gray-600">Location: On-site</p>
                            <p class="text-sm text-gray-600 mt-2">Salary: $18-22/hour</p>
                            <p class="text-sm text-gray-600">Posted: February 28, 2024</p>
                        </div>
                        <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                            Apply Now
                        </button>
                    </div>
                </div>

                <!-- Job Card 3 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Research Assistant</h3>
                            <p class="text-sm text-gray-600 mt-1">University Research Lab</p>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Research</span>
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Full-time</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Duration: 1 year</p>
                            <p class="text-sm text-gray-600">Location: Hybrid</p>
                            <p class="text-sm text-gray-600 mt-2">Salary: $25-30/hour</p>
                            <p class="text-sm text-gray-600">Posted: February 25, 2024</p>
                        </div>
                        <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                            Apply Now
                        </button>
                    </div>
                </div>

                <!-- Job Card 4 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Data Analyst Intern</h3>
                            <p class="text-sm text-gray-600 mt-1">Data Insights Corp</p>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Technology</span>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Internship</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Duration: 4 months</p>
                            <p class="text-sm text-gray-600">Location: Remote</p>
                            <p class="text-sm text-gray-600 mt-2">Salary: $20-25/hour</p>
                            <p class="text-sm text-gray-600">Posted: March 2, 2024</p>
                        </div>
                        <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Application Status -->
            <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Your Applications</h2>
                <div class="space-y-4">
                    <!-- Application Item 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-md font-medium text-gray-900">Software Developer Intern</h3>
                                <p class="text-sm text-gray-600 mt-1">Applied: February 15, 2024</p>
                                <p class="text-sm text-gray-600">Status: <span class="text-yellow-600 font-medium">Under Review</span></p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>
                    </div>

                    <!-- Application Item 2 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-md font-medium text-gray-900">Marketing Assistant</h3>
                                <p class="text-sm text-gray-600 mt-1">Applied: February 10, 2024</p>
                                <p class="text-sm text-gray-600">Status: <span class="text-green-600 font-medium">Interview Scheduled</span></p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 