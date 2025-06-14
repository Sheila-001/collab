

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <!-- Main Content -->
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h5 class="card-title mb-0">Donation Details</h5>
                    <div>
                        <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6 border-end pr-md-4">
                            <?php if($donation->proof_path || $donation->image_path): ?>
                            <h6 class="text-muted mb-3 border-bottom pb-2"><?php echo e($donation->type === 'monetary' ? 'Donation Proof' : 'Item Image'); ?></h6>
                            <div class="text-center mb-4">
                                <?php if($donation->proof_path): ?>
                                    <img src="<?php echo e(Storage::url($donation->proof_path)); ?>" alt="Donation Proof" class="img-fluid rounded max-h-96 mx-auto border shadow-sm">
                                <?php elseif($donation->image_path): ?>
                                    <img src="<?php echo e(Storage::url($donation->image_path)); ?>" alt="Item Image" class="img-fluid rounded max-h-96 mx-auto border shadow-sm">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 pl-md-4">
                            <h6 class="text-muted mb-3 border-bottom pb-2">Donor Information</h6>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Name</label>
                                <p class="mb-0"><?php echo e($donation->donor_name); ?></p>
                            </div>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Email</label>
                                <p class="mb-0"><?php echo e($donation->donor_email); ?></p>
                            </div>
                            
                            <?php if($donation->donor_phone ?? false): ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Phone</label>
                                <p class="mb-0"><?php echo e($donation->donor_phone); ?></p>
                            </div>
                            <?php endif; ?>

                            <h6 class="text-muted mb-3 mt-4 border-bottom pb-2">Donation Information</h6>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Type</label>
                                <p class="mb-0">
                                    <span class="badge bg-<?php echo e($donation->type === 'monetary' ? 'primary' : 'success'); ?>">
                                        <?php echo e(ucfirst($donation->type)); ?>

                                    </span>
                                </p>
                            </div>
                            <?php if($donation->type === 'monetary'): ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Amount</label>
                                <p class="mb-0">₱<?php echo e(number_format($donation->amount, 2)); ?></p>
                            </div>
                            
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Payment Method</label>
                                <p class="mb-0"><?php echo e(ucfirst($donation->payment_method)); ?></p>
                            </div>
                            <?php else: ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Expected Drop-off Date</label>
                                <p class="mb-0"><?php echo e($donation->expected_date?->format('M d, Y h:i A') ?? 'N/A'); ?></p>
                            </div>
                            
                            <?php if($donation->donor_phone): ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Contact Number</label>
                                <p class="mb-0"><?php echo e($donation->donor_phone); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($donation->notes): ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Note</label>
                                <p class="mb-0"><?php echo e($donation->notes); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($donation->category): ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Category</label>
                                <p class="mb-0"><?php echo e($donation->category); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($donation->condition): ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Item Condition</label>
                                <p class="mb-0"><?php echo e($donation->condition); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-<?php echo e($donation->status === 'completed' ? 'success' : ($donation->status === 'rejected' ? 'danger' : 'warning')); ?>">
                                        <?php echo e(ucfirst($donation->status)); ?>

                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Acknowledged</label>
                                <p class="mb-0"><?php echo e($donation->is_acknowledged ? 'Yes' : 'No'); ?></p>
                            </div>
                            
                            <div class="mb-3 pb-2 border-bottom">
                                <label class="form-label fw-bold">Anonymous</label>
                                <p class="mb-0"><?php echo e($donation->is_anonymous ? 'Yes' : 'No'); ?></p>
                            </div>
                        </div>
                    </div>

                    
                    <?php if($donation->status === 'pending'): ?>
                        <div class="row mt-4 border-top pt-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3 border-bottom pb-2">Update Status</h6>
                                <form action="<?php echo e(route('admin.donations.update-status', $donation->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="status">
                                            <option value="completed">Mark as Confirmed</option>
                                            <option value="rejected">Mark as Rejected</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($donation->notes): ?>
                    <div class="row mt-4 border-top pt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 border-bottom pb-2">Additional Notes</h6>
                            <div class="card bg-light shadow-sm">
                                <div class="card-body">
                                    <?php echo e($donation->notes); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Add any specific styles needed for this page */
.max-h-96 {
    max-height: 24rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Add any specific scripts needed for this page
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/donation/show.blade.php ENDPATH**/ ?>