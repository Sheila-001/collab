

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Donation Reports</h2>
        <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Donations
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Donations</h5>
                    <h3 class="mb-0">₱<?php echo e(number_format($totalDonations, 2)); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Donors</h5>
                    <h3 class="mb-0"><?php echo e($donations->unique('donor_id')->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Campaigns</h5>
                    <h3 class="mb-0"><?php echo e($donations->unique('campaign_id')->count()); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Donations Chart -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Monthly Donations</h5>
        </div>
        <div class="card-body">
            <canvas id="monthlyDonationsChart"></canvas>
        </div>
    </div>

    <!-- Campaign Statistics -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Campaign Statistics</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Total Donations</th>
                            <th>Number of Donors</th>
                            <th>Average Donation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $campaignStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaignId => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $campaign = $donations->firstWhere('campaign_id', $campaignId)->campaign;
                            ?>
                            <tr>
                                <td><?php echo e($campaign ? $campaign->title : 'N/A'); ?></td>
                                <td>₱<?php echo e(number_format($stats['total'], 2)); ?></td>
                                <td><?php echo e($stats['count']); ?></td>
                                <td>₱<?php echo e(number_format($stats['total'] / $stats['count'], 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyDonationsChart').getContext('2d');
    const monthlyData = <?php echo json_encode($monthlyDonations, 15, 512) ?>;
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(monthlyData),
            datasets: [{
                label: 'Monthly Donations',
                data: Object.values(monthlyData).map(donations => 
                    donations.reduce((sum, donation) => sum + donation.amount, 0)
                ),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('components.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\collab\resources\views/admin/donations/reports.blade.php ENDPATH**/ ?>