

<?php $__env->startSection('content'); ?>
    <div class="p-8 bg-[#f3f6fb] min-h-screen">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Pending Donations</h1>
                    <p class="text-sm text-gray-600 mt-1">Review and manage donations awaiting approval.</p>
                </div>
            </div>
            <form action="<?php echo e(route('admin.donations.pending')); ?>" method="GET" class="flex-grow max-w-sm ml-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="search_pending_donations" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo e(request('search_pending_donations')); ?>" />
                </div>
            </form>
        </div>
        
        <a href="<?php echo e(route('admin.donations.index')); ?>" class="inline-flex items-center px-4 py-2 mb-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
    </a>

        <!-- Pending Donations Table -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount/Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $pendingDonations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pendingDonation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($pendingDonation->donor_name); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($pendingDonation->donor_email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo e($pendingDonation->type === 'monetary' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                        <?php echo e(ucfirst($pendingDonation->type)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($pendingDonation->type === 'monetary'): ?>
                                        <div class="text-sm font-medium text-gray-900">₱<?php echo e(number_format($pendingDonation->amount, 2)); ?></div>
                                    <?php else: ?>
                                        <div class="text-sm text-gray-900"><?php echo e($pendingDonation->item_name); ?></div>
                                        <div class="text-sm text-gray-500">Qty: <?php echo e($pendingDonation->item_quantity ?? 1); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($pendingDonation->expected_date?->format('M d, Y') ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <form action="<?php echo e(route('admin.donations.update-status', $pendingDonation)); ?>" method="POST" class="inline-block">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Mark as Completed">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.donations.update-status', $pendingDonation)); ?>" method="POST" class="inline-block">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Mark as Cancelled">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No pending donations found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                <?php echo e($pendingDonations->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/donation/pending.blade.php ENDPATH**/ ?>