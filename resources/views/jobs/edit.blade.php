<x-app-layout>
    <div class="flex">
        <div class="w-64 min-h-screen bg-[#1B4B5A] text-white">
            <div class="p-4 flex items-center space-x-2">
                <img src="{{ asset('image/logohauzhayag.jpg') }}" alt="Hauz Hayag Logo" class="h-16 w-auto rounded-lg shadow-md">
                <h1 class="text-2xl font-bold">Hauz Hayag</h1>
            </div>
            <nav class="mt-8">
                <a href="/dashboard" class="flex items-center px-4 py-3 bg-[#2C5F6E] hover:bg-[#2C5F6E] transition-colors">Dashboard</a>
                <a href="/admin/jobs" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">Manage Jobs</a>
                <a href="/admin/jobs/create" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">Add Job</a>
                <div class="mt-auto pt-20">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors text-red-300 hover:text-red-200">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>
        <div class="flex-1 p-8 bg-gray-50">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Job Listing</h1>
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('jobs.update', $job->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-8 max-w-xl mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Title</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('title', $job->title) }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="4" required>{{ old('description', $job->description) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Company</label>
                    <input type="text" name="company" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('company', $job->company) }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Location</label>
                    <input type="text" name="location" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('location', $job->location) }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Salary</label>
                    <input type="text" name="salary" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('salary', $job->salary) }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Requirements</label>
                    <textarea name="requirements" class="w-full border border-gray-300 rounded px-3 py-2" rows="3">{{ old('requirements', $job->requirements) }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-secondary text-white px-6 py-2 rounded hover:bg-secondary/80 transition">Update Job</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 