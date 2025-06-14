

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Campaign Categories</h1>
            <p class="text-sm text-gray-600">Manage calendar campaign categories</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.calendar.index')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Calendar
            </a>
            <a href="<?php echo e(route('admin.calendar-categories.create')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-[#1B4B5A] text-white rounded-md hover:bg-[#2C5F6E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Category
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="h-4 w-4 fill-current" role="button" viewBox="0 0 20 20">
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </button>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-6 h-6 rounded" style="background-color: <?php echo e($category->color); ?>"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($category->name); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500"><?php echo e($category->description); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button type="button" 
                                           onclick="openEditModal('<?php echo e($category->id); ?>', '<?php echo e($category->name); ?>', '<?php echo e($category->color); ?>', '<?php echo e($category->description); ?>')"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button type="button"
                                              onclick="openDeleteModal('<?php echo e($category->id); ?>', '<?php echo e($category->name); ?>')"
                                              class="text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No categories found. <a href="<?php echo e(route('admin.calendar-categories.create')); ?>" class="text-[#1B4B5A] hover:underline">Create one now</a>.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Category</h3>
            <form id="editForm" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" 
                           name="name" 
                           id="edit_name" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#1B4B5A] focus:ring-[#1B4B5A]"
                           required>
                </div>

                <div>
                    <label for="edit_color" class="block text-sm font-medium text-gray-700">Color</label>
                    <input type="color" 
                           name="color" 
                           id="edit_color" 
                           class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-[#1B4B5A] focus:ring-[#1B4B5A]"
                           required>
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" 
                              id="edit_description" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#1B4B5A] focus:ring-[#1B4B5A]"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-[#1B4B5A] text-white rounded-md hover:bg-[#2C5F6E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Category</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete <span id="deleteCategoryName" class="font-medium"></span>? This action cannot be undone.</p>
            
            <form id="deleteForm" method="POST" class="flex justify-end space-x-3">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4B5A]">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function openEditModal(id, name, color, description) {
        console.log('openEditModal called for ID:', id);
        document.getElementById('editForm').action = `<?php echo e(url('admin/calendar-categories')); ?>/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_color').value = color;
        document.getElementById('edit_description').value = description || '';
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Handle edit form submission
    document.getElementById('editForm').addEventListener('submit', function(e) {
        console.log('Edit form submission triggered!');
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            console.log('Update Response:', response);
            if (!response.ok) {
                return response.json().then(data => Promise.reject(data));
            }
            return response.json();
        })
        .then(data => {
            console.log('Update Data:', data);
            if (data.success) {
                window.location.reload();
            } else {
                throw new Error(data.message || 'Failed to update category');
            }
        })
        .catch(error => {
            console.error('Update Error:', error);
            alert(error.message || 'Failed to update category. Please try again.');
        });
    });

    function openDeleteModal(id, name) {
        console.log('openDeleteModal called for ID:', id);
        document.getElementById('deleteForm').action = `<?php echo e(url('admin/calendar-categories')); ?>/${id}`;
        document.getElementById('deleteCategoryName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Handle delete form submission
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        console.log('Delete form submission triggered!');
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_method', 'DELETE');

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            console.log('Delete Response:', response);
            if (!response.ok) {
                return response.json().then(data => Promise.reject(data));
            }
            return response.json();
        })
        .then(data => {
            console.log('Delete Data:', data);
            if (data.success) {
                window.location.reload();
            } else {
                throw new Error(data.message || 'Failed to delete category');
            }
        })
        .catch(error => {
            console.error('Delete Error:', error);
            alert(error.message || 'Failed to delete category. Please try again.');
        });
    });

    // Close modals when clicking outside
    window.onclick = function(event) {
        let editModal = document.getElementById('editModal');
        let deleteModal = document.getElementById('deleteModal');
        
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/calendar/categories/index.blade.php ENDPATH**/ ?>