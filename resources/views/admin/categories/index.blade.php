<x-app-layout>
    <div class="p-6">
        <div class="mb-6">
            <a href="{{ route('admin.calendar.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-300 text-gray-600 rounded-md hover:bg-gray-400 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Back to Calendar</span>
            </a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-[#1B4B5A] text-white rounded-md hover:bg-[#2C5F6E] transition-colors">
                <i class="fas fa-plus mr-2"></i>
                <span>Add Category</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider pr-10">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="w-6 h-6 rounded mr-2" style="background-color: {{ $category->color }}"></span>
                                        <span class="text-sm text-gray-600">{{ $category->color }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 line-clamp-2">{{ $category->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.categories.edit', $category->slug) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-[#1B4B5A] text-white rounded-md hover:bg-[#2C5F6E] transition-colors">
                                            <i class="fas fa-edit text-sm"></i>
                                            <span class="ml-2">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->slug) }}" 
                                              method="POST" 
                                              class="inline-flex"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                                <i class="fas fa-trash text-sm"></i>
                                                <span class="ml-2">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 