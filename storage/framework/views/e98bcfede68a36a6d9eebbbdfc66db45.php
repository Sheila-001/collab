

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header Row: Title and User Badge -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-2">
                <span class="text-gray-500">Admin</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold">AD</span>
            </div>
        </div>
        <!-- Statistic Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Monetary Donations</span>
                <span class="text-3xl font-bold mt-2"><?php echo e(number_format($monetaryTotal ?? $monetaryDonations ?? 0)); ?></span>
                <span class="text-sm mt-1 text-green-600"><?php echo e(number_format($monetaryChange ?? 0, 1)); ?>% from last month</span>
                <span class="absolute top-6 right-6 h-3 w-3 rounded-full bg-blue-100"></span>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Non-Monetary Items</span>
                <span class="text-3xl font-bold mt-2"><?php echo e(number_format($nonMonetaryCount ?? $nonMonetaryItems ?? 0)); ?></span>
                <span class="text-sm mt-1 text-green-600"><?php echo e(number_format($nonMonetaryChange ?? 0, 1)); ?>% from last month</span>
                <span class="absolute top-6 right-6 h-3 w-3 rounded-full bg-purple-100"></span>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Campaign</span>
                <span class="text-3xl font-bold mt-2"><?php echo e(number_format($campaignTotal ?? 0)); ?></span>
                <span class="text-sm mt-1 text-green-600"><?php echo e(number_format($campaignChange ?? 0, 1)); ?>% from last month</span>
                <span class="absolute top-6 right-6 h-3 w-3 rounded-full bg-orange-100"></span>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Total Donors</span>
                <span class="text-3xl font-bold mt-2"><?php echo e(number_format($donorCount ?? $totalDonors ?? 0)); ?></span>
                <span class="text-sm mt-1 text-green-600"><?php echo e(number_format($donorChange ?? 0, 1)); ?>% from last month</span>
                <span class="absolute top-6 right-6 h-3 w-3 rounded-full bg-green-100"></span>
            </div>
        </div>

        <!-- Recent Donations Card -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <h2 class="font-bold text-lg">Recent Donations</h2>
                <div class="flex items-center gap-2">
                    <input type="text" class="border border-gray-300 rounded px-3 py-2 text-sm" placeholder="Search donors..." id="donorSearch">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">Filter</button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Donor</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-2 flex items-center gap-3">
                                <?php
                                    $colors = ['bg-green-300 text-green-900', 'bg-blue-300 text-blue-900', 'bg-yellow-300 text-yellow-900', 'bg-pink-300 text-pink-900', 'bg-purple-300 text-purple-900', 'bg-cyan-300 text-cyan-900'];
                                    $color = $colors[crc32($donation->donor_name) % count($colors)];
                                    $nameParts = explode(' ', $donation->donor_name);
                                    $initials = strtoupper(substr($nameParts[0], 0, 1));
                                    if (count($nameParts) > 1) {
                                        $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                    }
                                ?>
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full font-bold <?php echo e($color); ?>">
                                    <?php echo e($initials); ?>

                                </span>
                                <div>
                                    <div class="font-semibold"><?php echo e($donation->donor_name); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($donation->donor_email); ?></div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold <?php echo e($donation->type === 'monetary' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'); ?>">
                                    <?php echo e(ucfirst($donation->type)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2 font-bold">
                                <?php if($donation->proof_path): ?>
                                    <img src="<?php echo e(Storage::url($donation->proof_path)); ?>" alt="Donation Proof" class="w-8 h-8 object-cover rounded inline-block mr-2">
                                    <span class="font-semibold">Donation Proof</span>
                                <?php elseif($donation->type === 'monetary'): ?>
                                    ₱<?php echo e(number_format($donation->amount, 2)); ?>

                                <?php else: ?>
                                    Category: <?php echo e($donation->item_name); ?><br>
                                    Condition: <?php echo e($donation->condition ?? 'N/A'); ?><br>
                                    Description: <?php echo e($donation->description ?? 'N/A'); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold <?php echo e($donation->status === 'completed' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800'); ?>">
                                    <?php echo e(ucfirst($donation->status)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span><?php echo e($donation->created_at?->format('M d, Y') ?? 'N/A'); ?></span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="flex flex-col gap-1 md:flex-row md:gap-2 justify-end">
                                    <a href="<?php echo e(route('admin.donations.show', $donation)); ?>" class="text-blue-600 hover:underline text-xs">View Details</a>
                                    <a href="<?php echo e(route('admin.donations.edit', $donation)); ?>" class="text-yellow-600 hover:underline text-xs">Edit</a>
                                    <?php if($donation->type === 'non-monetary' && $donation->status === 'pending'): ?>
                                    <form action="<?php echo e(route('admin.donations.update-status', $donation)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="text-green-600 hover:underline text-xs">Mark as Received</button>
                                    </form>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('admin.donations.destroy', $donation)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:underline text-xs" onclick="return confirm('Are you sure you want to delete this donation?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <?php echo e($donations->links()); ?>

            </div>
        </div>

        <!-- Drop-Off Confirmation Section -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <h3 class="text-lg font-semibold mb-4 md:mb-0">Drop-Off Confirmation</h3>
                <a href="<?php echo e(route('admin.donations.dropoffs')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">Manage Drop-Offs</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Expected Drop-off Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $pendingDropoffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dropoff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo e($dropoff->item_name); ?> - <?php echo e($dropoff->quantity); ?> units</td>
                            <td class="px-4 py-2"><?php echo e($dropoff->expected_date?->format('M d, Y') ?? 'N/A'); ?></td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-yellow-200 text-yellow-800">Pending</span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <form action="<?php echo e(route('admin.donations.update-status', $dropoff)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="text-green-600 hover:underline text-xs">Confirm Receipt</button>
                                    </form>
                                    <form action="<?php echo e(route('admin.donations.update-status', $dropoff)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-600 hover:underline text-xs">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.dropdown-item {
    padding: 0.5rem 1rem;
}

.dropdown-item i {
    width: 1.25rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('donorSearch');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('table tbody tr').forEach(row => {
            const donorName = row.querySelector('td:first-child').textContent.toLowerCase();
            const donorEmail = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            row.style.display = donorName.includes(searchTerm) || donorEmail.includes(searchTerm) ? '' : 'none';
        });
    });

    // Filter functionality
    document.querySelectorAll('[data-filter]').forEach(filter => {
        filter.addEventListener('click', function(e) {
            e.preventDefault();
            const filterValue = this.dataset.filter;
            document.querySelectorAll('table tbody tr').forEach(row => {
                if (filterValue === 'all') {
                    row.style.display = '';
                    return;
                }
                const type = row.querySelector('td:nth-child(3) .badge').textContent.toLowerCase();
                const status = row.querySelector('td:nth-child(5) .badge').textContent.toLowerCase();
                row.style.display = (type === filterValue || status === filterValue) ? '' : 'none';
            });
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/donation/adddonation.blade.php ENDPATH**/ ?>