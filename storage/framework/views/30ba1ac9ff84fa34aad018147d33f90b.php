

<?php $__env->startSection('content'); ?>
    <div class="p-8 bg-[#f3f6fb] min-h-screen">
        <!-- Header Row: Title and User Badge -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Donation Management</h1>
                <p class="text-sm text-gray-600 mt-1">Manage and track all donations</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-gray-600">Admin</span>
                <div class="bg-blue-200 text-blue-700 rounded-full px-3 py-1 font-semibold">AD</div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Monetary Donations Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-semibold">Monetary Donations</span>
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-full">
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold">₱<?php echo e(number_format($monetaryTotal ?? 0, 2)); ?></span>
                    <span class="text-sm text-green-500 mt-1">↑12% from last month</span>
                </div>
            </div>

            <!-- Non-Monetary Items Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-semibold">Non-Monetary Items</span>
                    <span class="bg-purple-100 text-purple-600 p-2 rounded-full">
                        <i class="fas fa-box"></i>
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold"><?php echo e($nonMonetaryCount ?? 0); ?></span>
                    <span class="text-sm text-green-500 mt-1">↑8% from last month</span>
                </div>
            </div>

            <!-- Total Campaigns Card (New Position) -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-semibold">Total Campaigns</span>
                    <span class="bg-yellow-100 text-yellow-600 p-2 rounded-full">
                        <i class="fas fa-bullhorn"></i>
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold"><?php echo e($totalCampaigns ?? 0); ?></span>
                    <span class="text-sm text-yellow-500 mt-1"><?php echo e(number_format($campaignChange, 2)); ?>% from last month</span>
                </div>
            </div>

            <!-- Total Donors Card (New Position) -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-semibold">Total Donors</span>
                    <span class="bg-green-100 text-green-600 p-2 rounded-full">
                        <i class="fas fa-users"></i>
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold"><?php echo e($donorCount ?? 0); ?></span>
                    <span class="text-sm text-green-500 mt-1"><?php echo e(number_format($donorChange, 2)); ?>% from last month</span>
                </div>
            </div>
        </div>

        <!-- Pending Donations Section (New) -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Pending Donations</h2>
                <div class="flex items-center space-x-4">
                    <form action="<?php echo e(route('admin.donations.index')); ?>" method="GET" class="flex-grow max-w-xs">
                        <label for="pending-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="pending-search" name="search_dashboard_pending" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search pending..." value="<?php echo e(request('search_dashboard_pending')); ?>" />
                        </div>
                    </form>
                    <a href="<?php echo e(route('admin.donations.pending')); ?>" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">See All Pending</a>
                </div>
            </div>

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
        </div>

        <!-- Recent Donations Table -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Recent Donations</h2>
                <div class="flex items-center space-x-4">
                    <form action="<?php echo e(route('admin.donations.index')); ?>" method="GET" class="flex-grow">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" name="search_donations" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo e(request('search_donations')); ?>" />
                        </div>
                    </form>

                    <a href="<?php echo e(route('admin.donations.all-donors')); ?>" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ml-4">See All Donations</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount/Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proof</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" 
                                                 src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($donation->donor_name)); ?>&background=random" 
                                                 alt="<?php echo e($donation->donor_name); ?>">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($donation->donor_name); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($donation->donor_email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo e($donation->type === 'monetary' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                        <?php echo e(ucfirst($donation->type)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($donation->type === 'monetary'): ?>
                                        <div class="text-sm font-medium text-gray-900">₱<?php echo e(number_format($donation->amount, 2)); ?></div>
                                    <?php else: ?>
                                        <div class="text-sm text-gray-900"><?php echo e($donation->item_name); ?></div>
                                        <div class="text-sm text-gray-500">Qty: <?php echo e($donation->quantity ?? 1); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo e($donation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e(ucfirst($donation->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($donation->created_at->format('M d, Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($donation->proof_path): ?>
                                        <img src="<?php echo e(Storage::url($donation->proof_path)); ?>" 
                                             alt="Donation Proof" 
                                             class="h-10 w-10 rounded-lg object-cover cursor-pointer hover:opacity-75"
                                             onclick="showProofModal('<?php echo e(Storage::url($donation->proof_path)); ?>')">
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="<?php echo e(route('admin.donations.show', $donation)); ?>" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.donations.destroy', $donation)); ?>" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this donation?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No donations found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            
        </div>

        <!-- Removed Drop-Off Confirmation Section -->
        
    </div>

    <!-- Proof Image Modal -->
    <div id="proofModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Donation Proof</h3>
                <button onclick="closeProofModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <img id="proofModalImage" src="" alt="Donation Proof" class="w-full h-auto rounded-lg">
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/donation-panel.css')); ?>">
<?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function showProofModal(imageSrc) {
            document.getElementById('proofModalImage').src = imageSrc;
            document.getElementById('proofModal').classList.remove('hidden');
            document.getElementById('proofModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeProofModal() {
            document.getElementById('proofModal').classList.add('hidden');
            document.getElementById('proofModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('proofModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProofModal();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('proofModal').classList.contains('hidden')) {
                closeProofModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Make donation rows clickable
            document.querySelectorAll('.donation-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    if (!e.target.closest('.dropdown')) {
                        window.location.href = this.dataset.href;
                    }
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/donation/index.blade.php ENDPATH**/ ?>