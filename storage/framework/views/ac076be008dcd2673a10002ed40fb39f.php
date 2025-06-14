

<?php $__env->startSection('content'); ?>
    <div class="p-8 bg-[#f3f6fb] min-h-screen">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Volunteer Management</h1>
            <div class="flex items-center space-x-2">
                <span class="text-gray-600">Admin</span>
                <div class="bg-blue-200 text-blue-700 rounded-full px-3 py-1 font-semibold">AD</div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-gray-700">Total Volunteers</span>
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-full">
                        <i class="fas fa-users"></i>
                    </span>
                </div>
                <span class="mt-4 text-2xl font-bold"><?php echo e($volunteers->total()); ?></span>
                        </div>
            <div class="bg-white rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-gray-700">Active Volunteers</span>
                    <span class="bg-green-100 text-green-600 p-2 rounded-full">
                        <i class="fas fa-user-check"></i>
                    </span>
                </div>
                <span class="mt-4 text-2xl font-bold"><?php echo e($activeVolunteersCount); ?></span>
                    </div>
                </div>
                
        <!-- Volunteers Table -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-lg">Volunteer List</h2>
                <div class="flex items-center space-x-2">
                    <input type="text" placeholder="Search volunteers..." class="border rounded px-3 py-1 text-sm">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded">Filter</button>
                </div>
            </div>
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 text-left">Name</th>
                        <th class="py-2 text-left">Email</th>
                        <th class="py-2 text-left">Status</th>
                        <th class="py-2 text-left">Joined Date</th>
                        <th class="py-2 text-left">Actions</th>
            </tr>
        </thead>
                <tbody>
                                <?php $__currentLoopData = $volunteers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $volunteer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b">
                        <td class="py-3"><?php echo e($volunteer->name); ?></td>
                        <td class="py-3"><?php echo e($volunteer->email); ?></td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded text-sm
                                <?php if($volunteer->status === 'Active'): ?> bg-green-100 text-green-600
                                <?php elseif($volunteer->status === 'Pending'): ?> bg-yellow-100 text-yellow-600
                                <?php else: ?> bg-red-100 text-red-600
                                <?php endif; ?>">
                                                <?php echo e($volunteer->status); ?>

                                            </span>
                                        </td>
                        <td class="py-3"><?php echo e($volunteer->created_at->format('M d, Y')); ?></td>
                        <td class="py-3">
                            <div class="flex space-x-2">
                                <?php if($volunteer->status === 'Pending'): ?>
                                <form action="<?php echo e(route('admin.volunteers.approve', $volunteer->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="bg-green-100 text-green-600 px-2 py-1 rounded">Approve</button>
                                </form>
                                <form action="<?php echo e(route('admin.volunteers.reject', $volunteer->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="bg-red-100 text-red-600 px-2 py-1 rounded">Reject</button>
                                </form>
                                <?php endif; ?>
                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
            <div class="mt-4">
                <?php echo e($volunteers->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/volunteers/index.blade.php ENDPATH**/ ?>