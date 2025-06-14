

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Urgent Campaign</h1>
            <p class="text-sm text-gray-600 mt-1">Update the details of the urgent campaign.</p>
        </div>
        <a href="<?php echo e(route('admin.urgent-campaigns.show', $urgentCampaign->id)); ?>" class="btn btn-secondary">Back to Details</a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="<?php echo e(route('admin.urgent-campaigns.update', $urgentCampaign->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo e(old('title', $urgentCampaign->title)); ?>" required>
            </div>
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo e(old('description', $urgentCampaign->description)); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="goal_amount" class="form-label">Goal Amount</label>
                <input type="number" class="form-control" id="goal_amount" name="goal_amount" step="0.01" value="<?php echo e(old('goal_amount', $urgentCampaign->goal_amount)); ?>" required>
            </div>
            <div class="mb-4">
                <label for="ends_at" class="form-label">Ends At (Optional)</label>
                <input type="datetime-local" class="form-control" id="ends_at" name="ends_at" value="<?php echo e(old('ends_at', $urgentCampaign->ends_at ? $urgentCampaign->ends_at->format('Y-m-d\\TH:i') : '')); ?>">
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', $urgentCampaign->is_active) ? 'checked' : ''); ?>>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Update Campaign</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/urgent_campaigns/edit.blade.php ENDPATH**/ ?>