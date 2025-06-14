

<?php $__env->startSection('title', 'Student Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome, <?php echo e(auth()->user()->name); ?>!</h1>
        <p class="text-gray-600">Stay updated with our latest campaigns and make a difference today.</p>
    </div>

    <!-- Active Campaigns Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Active Campaigns</h2>
            <a href="<?php echo e(route('user.calendar')); ?>" class="text-blue-600 hover:text-blue-800">View Calendar</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $campaigns ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border border-gray-200 rounded-lg p-4">
                    <?php if($campaign->image): ?>
                        <img src="<?php echo e(Storage::url($campaign->image)); ?>" 
                             alt="<?php echo e($campaign->title); ?>" 
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    <?php endif; ?>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($campaign->title); ?></h3>
                    <p class="text-gray-600 text-sm mb-4"><?php echo e(Str::limit($campaign->description, 100)); ?></p>
                    
                    <div class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <?php
                                $progress = ($campaign->goal_amount > 0) ? min(($campaign->funds_raised / $campaign->goal_amount) * 100, 100) : 0;
                            ?>
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo e($progress); ?>%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                            <span>₱<?php echo e(number_format($campaign->funds_raised, 2)); ?> raised</span>
                            <span><?php echo e(number_format($progress)); ?>%</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            <?php echo e($campaign->end_date ? $campaign->end_date->diffForHumans() : 'No end date'); ?>

                        </span>
                        <a href="<?php echo e(route('monetary_donation')); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                            Donate Now
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No active campaigns at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="<?php echo e(route('events.index')); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Events</h3>
            <p class="text-gray-600">View and join upcoming events</p>
        </a>
        
        <a href="<?php echo e(route('jobs.listings')); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Job Listings</h3>
            <p class="text-gray-600">Explore career opportunities</p>
        </a>
        
        <a href="<?php echo e(route('scholarship.track')); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Scholarship Status</h3>
            <p class="text-gray-600">Track your scholarship application</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/student/dashboard.blade.php ENDPATH**/ ?>