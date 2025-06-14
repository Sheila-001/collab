<x-app-layout>
    <div class="flex">
        <!-- Sidebar (reuse from your other pages) -->
        <div class="w-64 min-h-screen bg-[#1B4B5A] text-white">
            <div class="p-4 flex items-center space-x-2">
                <img src="{{ asset('image/logohauzhayag.jpg') }}" alt="Hauz Hayag Logo" class="h-16 w-auto rounded-lg shadow-md">
                <h1 class="text-2xl font-bold">Hauz Hayag</h1>
            </div>
            <nav class="mt-8">
                <a href="/dashboard" class="flex items-center px-4 py-3 bg-[#2C5F6E] hover:bg-[#2C5F6E] transition-colors">Dashboard</a>
                <a href="/jobs" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">Jobs</a>
                <a href="/admin/jobs/create" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors font-bold">Add Job</a>
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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Job Listing</h1>
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.jobs.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-8 max-w-xl mx-auto">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('title') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" name="company_name" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('company_name') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Role <span class="text-red-500">*</span></label>
                    <input type="text" name="role" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('role') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="4" required>{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Qualifications <span class="text-red-500">*</span></label>
                    <textarea name="qualifications" class="w-full border border-gray-300 rounded px-3 py-2" rows="3" required>{{ old('qualifications') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Employment Type</label>
                    <select name="employment_type" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Type</option>
                        <option value="Full-time" {{ old('employment_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Part-time" {{ old('employment_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                        <option value="Temporary" {{ old('employment_type') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Location</label>
                    <input type="text" name="location" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('location') }}">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Minimum Salary</label>
                        <input type="number" name="salary_min" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('salary_min') }}" min="0" step="0.01">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Maximum Salary</label>
                        <input type="number" name="salary_max" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('salary_max') }}" min="0" step="0.01">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Contact Person <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_person" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('contact_person') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Contact Email <span class="text-red-500">*</span></label>
                    <input type="email" name="contact_email" class="w-full border border-gray-300 rounded px-3 py-2" required value="{{ old('contact_email') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Contact Phone</label>
                    <input type="tel" name="contact_phone" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('contact_phone') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Expiry Date</label>
                    <input type="date" name="expires_at" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('expires_at') }}">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-secondary text-white px-6 py-2 rounded hover:bg-secondary/80 transition">Add Job</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 