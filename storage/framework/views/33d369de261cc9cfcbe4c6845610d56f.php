

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header Row: Title and User Badge -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Dashboard Overview</h1>
            <div class="flex items-center gap-2">
                <span class="text-gray-500">Admin</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold">AD</span>
            </div>
        </div>

        <!-- Statistic Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Monetary Donations</span>
                <span id="monetaryTotal" class="text-3xl font-bold mt-2">₱<?php echo e(number_format($monetaryTotal, 2)); ?></span>
                <?php if($monetaryChange != 0): ?>
                    <span id="monetaryChange" class="text-sm <?php echo e($monetaryChange > 0 ? 'text-green-500' : 'text-red-500'); ?> mt-1">
                        <?php echo e($monetaryChange > 0 ? '+' : ''); ?><?php echo e(number_format($monetaryChange, 1)); ?>%
                    </span>
                <?php else: ?>
                    <span id="monetaryChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                <?php endif; ?>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Non-Monetary Donations</span>
                <span id="nonMonetaryCount" class="text-3xl font-bold mt-2"><?php echo e($nonMonetaryCount); ?></span>
                <?php if($nonMonetaryChange != 0): ?>
                    <span id="nonMonetaryChange" class="text-sm <?php echo e($nonMonetaryChange > 0 ? 'text-green-500' : 'text-red-500'); ?> mt-1">
                        <?php echo e($nonMonetaryChange > 0 ? '+' : ''); ?><?php echo e(number_format($nonMonetaryChange, 1)); ?>%
                    </span>
                <?php else: ?>
                    <span id="nonMonetaryChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                <?php endif; ?>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Campaign Donations</span>
                <span id="campaignTotal" class="text-3xl font-bold mt-2">₱<?php echo e(number_format($campaignTotal, 2)); ?></span>
                <?php if($campaignChange != 0): ?>
                    <span id="campaignChange" class="text-sm <?php echo e($campaignChange > 0 ? 'text-green-500' : 'text-red-500'); ?> mt-1">
                        <?php echo e($campaignChange > 0 ? '+' : ''); ?><?php echo e(number_format($campaignChange, 1)); ?>%
                    </span>
                <?php else: ?>
                    <span id="campaignChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                <?php endif; ?>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Total Donors</span>
                <span id="donorCount" class="text-3xl font-bold mt-2"><?php echo e($donorCount); ?></span>
                <?php if($donorChange != 0): ?>
                    <span id="donorChange" class="text-sm <?php echo e($donorChange > 0 ? 'text-green-500' : 'text-red-500'); ?> mt-1">
                        <?php echo e($donorChange > 0 ? '+' : ''); ?><?php echo e(number_format($donorChange, 1)); ?>%
                    </span>
                <?php else: ?>
                    <span id="donorChange" class="text-sm text-gray-500 mt-1">0.0%</span>
                <?php endif; ?>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start relative">
                <span class="text-gray-500 font-semibold">Pending Donations</span>
                <span id="pendingDonations" class="text-3xl font-bold mt-2"><?php echo e($pendingDonations); ?></span>
                <span class="text-sm text-yellow-600 mt-1">Awaiting confirmation</span>
            </div>
        </div>

        <!-- Recent Donations and Pending Drop-offs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Donations -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg">Recent Donations</h2>
                    <a href="<?php echo e(route('admin.donations.index')); ?>" class="text-blue-600 hover:underline">View all</a>
                </div>
                <?php if($donations->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold"><?php echo e($donation->donor_name); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($donation->type === 'monetary' ? '₱' . number_format($donation->amount, 2) : 'Non-monetary'); ?></p>
                                    </div>
                                    <span class="px-2 py-1 rounded text-sm <?php echo e($donation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e(ucfirst($donation->status)); ?>

                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1"><?php echo e($donation->created_at->format('M d, Y H:i A')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No recent donations found.</p>
                <?php endif; ?>
            </div>

            <!-- Pending Drop-offs -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg">Pending Drop-offs</h2>
                    <a href="<?php echo e(route('admin.donations.dropoffs')); ?>" class="text-blue-600 hover:underline">View all</a>
                </div>
                <?php if($pendingDropoffs->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $pendingDropoffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dropoff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                <p class="font-semibold"><?php echo e($dropoff->donor_name); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($dropoff->description); ?></p>
                                <p class="text-sm text-gray-500 mt-1">Expected: <?php echo e($dropoff->dropoff_date ? $dropoff->dropoff_date->format('M d, Y') : 'Not specified'); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No pending drop-offs.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    console.log("Dashboard update script is running!");

    function updateDonationStats() {
        fetch('/api/admin/donation-stats', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('monetaryTotal').textContent = `₱${data.monetaryTotal}`;
            updateChangeSpan('monetaryChange', data.monetaryChange);

            document.getElementById('nonMonetaryCount').textContent = data.nonMonetaryCount;
            updateChangeSpan('nonMonetaryChange', data.nonMonetaryChange);

            document.getElementById('campaignTotal').textContent = `₱${data.monetaryTotal}`;
            updateChangeSpan('campaignChange', data.monetaryChange);

            document.getElementById('donorCount').textContent = data.donorCount;
            updateChangeSpan('donorChange', data.donorChange);

            document.getElementById('pendingDonations').textContent = data.pendingDonations;
        })
        .catch(error => console.error('Error fetching donation stats:', error));
    }

    function updateChangeSpan(id, changeValue) {
        const span = document.getElementById(id);
        if (span) {
            span.textContent = `${changeValue > 0 ? '+' : ''}${changeValue}%`;
            span.classList.remove('text-green-500', 'text-red-500', 'text-gray-500');
            if (changeValue > 0) {
                span.classList.add('text-green-500');
            } else if (changeValue < 0) {
                span.classList.add('text-red-500');
            } else {
                span.classList.add('text-gray-500');
            }
        }
    }

    // Update every 5 seconds
    setInterval(updateDonationStats, 5000);

    // Initial load
    document.addEventListener('DOMContentLoaded', updateDonationStats);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>