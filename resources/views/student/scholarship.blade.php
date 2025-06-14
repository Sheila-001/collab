<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Portal</title>
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
                <a href="/student/scholarship" class="flex items-center px-4 py-3 bg-[#2C5F6E]">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Scholarship
                </a>
                <a href="/student/jobs" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
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
                            <i class="fas fa-sign-out-alt mr-3"></i>
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
                <h1 class="text-2xl font-bold text-gray-800">Scholarship Portal</h1>
                <p class="text-gray-600">Manage your scholarship applications and track your status</p>
            </div>

            <!-- Current Scholarship Status -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Current Scholarship Status</h2>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Academic Excellence Scholarship</h3>
                            <p class="text-sm text-gray-600 mt-1">Status: <span class="text-green-600 font-medium">Active</span></p>
                            <p class="text-sm text-gray-600">Monthly Stipend: $500</p>
                            <p class="text-sm text-gray-600">Next Payment: March 1, 2024</p>
                            <p class="text-sm text-gray-600">Duration: Academic Year 2023-2024</p>
                            <p class="text-sm text-gray-600">Requirements Met: 3.8 GPA</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Current
                        </span>
                    </div>
                </div>
            </div>

            <!-- Available Scholarships -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Available Scholarships</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Scholarship Card 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-900">Merit Scholarship</h3>
                        <p class="text-sm text-gray-600 mt-1">Full tuition coverage for outstanding academic performance</p>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Requirements:</p>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <li>Minimum 3.5 GPA</li>
                                <li>Full-time enrollment</li>
                                <li>No academic probation</li>
                            </ul>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Deadline: April 30, 2024</span>
                            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                                Apply Now
                            </button>
                        </div>
                    </div>

                    <!-- Scholarship Card 2 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-900">Research Grant</h3>
                        <p class="text-sm text-gray-600 mt-1">Funding for undergraduate research projects</p>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Requirements:</p>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <li>Research proposal</li>
                                <li>Faculty recommendation</li>
                                <li>3.0 minimum GPA</li>
                            </ul>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Deadline: May 15, 2024</span>
                            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                                Apply Now
                            </button>
                        </div>
                    </div>

                    <!-- Scholarship Card 3 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-900">Leadership Scholarship</h3>
                        <p class="text-sm text-gray-600 mt-1">Recognition for student leadership and community service</p>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Requirements:</p>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <li>Leadership experience</li>
                                <li>Community service hours</li>
                                <li>3.2 minimum GPA</li>
                            </ul>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Deadline: May 1, 2024</span>
                            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                                Apply Now
                            </button>
                        </div>
                    </div>

                    <!-- Scholarship Card 4 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-900">STEM Excellence Award</h3>
                        <p class="text-sm text-gray-600 mt-1">Support for students in Science, Technology, Engineering, and Mathematics</p>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Requirements:</p>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <li>STEM major</li>
                                <li>3.7 minimum GPA</li>
                                <li>Research or project experience</li>
                            </ul>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Deadline: April 15, 2024</span>
                            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application History -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Application History</h2>
                <div class="space-y-4">
                    <!-- History Item 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-md font-medium text-gray-900">Academic Excellence Scholarship</h3>
                                <p class="text-sm text-gray-600 mt-1">Applied: January 15, 2024</p>
                                <p class="text-sm text-gray-600">Status: <span class="text-green-600 font-medium">Approved</span></p>
                                <p class="text-sm text-gray-600">Award Amount: $500/month</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </div>
                    </div>

                    <!-- History Item 2 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-md font-medium text-gray-900">Research Grant</h3>
                                <p class="text-sm text-gray-600 mt-1">Applied: February 1, 2024</p>
                                <p class="text-sm text-gray-600">Status: <span class="text-yellow-600 font-medium">Under Review</span></p>
                                <p class="text-sm text-gray-600">Requested Amount: $2,000</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>
                    </div>

                    <!-- History Item 3 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-md font-medium text-gray-900">Leadership Scholarship</h3>
                                <p class="text-sm text-gray-600 mt-1">Applied: December 10, 2023</p>
                                <p class="text-sm text-gray-600">Status: <span class="text-red-600 font-medium">Not Selected</span></p>
                                <p class="text-sm text-gray-600">Reason: Insufficient leadership experience</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Declined
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 