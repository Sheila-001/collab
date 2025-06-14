

<?php $__env->startSection('content'); ?>
<div class="flex">
    <div class="w-64 min-h-screen bg-[#1B4B5A] text-white">
        <div class="p-4 flex items-center space-x-2">
            <img src="<?php echo e(asset('image/logohauzhayag.jpg')); ?>"
                 alt="Hauz Hayag Logo"
                 class="h-16 w-auto rounded-lg shadow-md">
            <h1 class="text-2xl font-bold">Hauz Hayag</h1>
        </div>
        <nav class="mt-8">
            <a href="/dashboard" class="flex items-center px-4 py-3 bg-[#2C5F6E] hover:bg-[#2C5F6E] transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="/users" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                User Management
            </a>
            <a href="/events" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Events
            </a>
            <a href="/students" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Students
            </a>
            <a href="/volunteers" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Volunteers
            </a>
            <a href="/admin/jobs" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Jobs
            </a>

            <a href="<?php echo e(route('admin.donations.index')); ?>" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors">
                 <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1 .668.81 1.095 1.945 1.095 3 0 1.415-.842 2.607-2.035 3.262C11.923 16.468 10.055 18 8 18a7.987 7.987 0 01-2.343-2.599A7.987 7.987 0 014 12c0-1.415.842-2.607 2.035-3.262C6.077 7.532 7.945 6 10 6z"/>
               </svg>
                 Donations
               </a>

            <div class="mt-auto pt-20">
                <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center px-4 py-3 hover:bg-[#2C5F6E] transition-colors text-red-300 hover:text-red-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>
    <div class="flex-1 bg-gray-100">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Job Listings Management</h2>
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded font-semibold text-lg shadow hover:bg-gray-300 transition">
                        <span class="mr-2">&#8592;</span> Back to Dashboard
                    </a>
                    <a href="<?php echo e(route('admin.jobs.create')); ?>" class="inline-flex items-center px-8 py-3 bg-green-600 text-white rounded font-bold text-lg shadow-lg hover:bg-green-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">
                        <span class="mr-2 text-2xl">+</span> Create Job
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posted By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expires</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-4 py-3"><?php echo e($job->title); ?></td>
                                <td class="px-4 py-3"><?php echo e($job->company_name ?? 'N/A'); ?></td>
                                <td class="px-4 py-3"><?php echo e($job->role); ?></td>
                                <td class="px-4 py-3"><?php echo e($job->employment_type ?? 'N/A'); ?></td>
                                <td class="px-4 py-3"><?php echo e($job->location ?? 'N/A'); ?></td>
                                <td class="px-4 py-3">
                                    <?php if($job->status === 'approved'): ?>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">Approved</span>
                                    <?php elseif($job->status === 'pending'): ?>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">Pending</span>
                                    <?php else: ?>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($job->is_admin_posted): ?>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">Admin</span>
                                    <?php else: ?>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-cyan-100 text-cyan-800 rounded">Public</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($job->expires_at): ?>
                                        <?php echo e($job->expires_at->format('M d, Y')); ?>

                                        <?php if($job->expires_at < now()): ?>
                                            <br><span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">Expired</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400">No expiry</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-1">
                                        <a href="<?php echo e(route('admin.jobs.show', $job)); ?>" class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200" title="View">
                                            View
                                        </a>
                                        <a href="<?php echo e(route('admin.jobs.edit', $job)); ?>" class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200" title="Edit">
                                            Edit
                                        </a>
                                        <?php if(!$job->is_admin_posted && $job->status === 'pending'): ?>
                                            <form action="<?php echo e(route('admin.jobs.approve', $job)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200" title="Approve">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.jobs.reject', $job)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Reject">
                                                    Reject
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('admin.jobs.destroy', $job)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job listing?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200" title="Delete">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-400">
                                    No job listings found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-center">
                <?php echo e($jobs->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .btn-group .btn { margin-right: 2px; }
    .table td, .table th { vertical-align: middle; }
    .table th { white-space: nowrap; }
</style>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/jobs/index.blade.php ENDPATH**/ ?>