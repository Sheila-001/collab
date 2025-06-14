<!DOCTYPE html>
<html>
<head>
    <title>Donation Received</title>
</head>
<body>
    <p>Dear <?php echo e($donation->donor_name ?? 'Donor'); ?>,</p>

    <?php if($donation_type === 'monetary'): ?>
        <p>Thank you for your generous monetary donation. We have successfully received it.</p>

        <p>Here are the details of your donation:</p>
        <p>Amount: ₱<?php echo e(number_format($donation->amount ?? 0, 2)); ?></p>
        <p>Date: <?php echo e($donation->created_at?->format('M d, Y h:i A')); ?></p>

    <?php elseif($donation_type === 'non-monetary'): ?>
        <p>Thank you for your non-monetary donation. We have confirmed receipt of your generous contribution.</p>
        <p>Here are the details of your donation and confirmation:</p>
        <p>Quantity: <?php echo e($donation->quantity ?? 'N/A'); ?></p>
        <p>Category: <?php echo e($donation->category ?? 'N/A'); ?></p>
        <p>Item Condition: <?php echo e($donation->condition ?? 'N/A'); ?></p>
        <?php if($donation->expected_date): ?>
            <p>Scheduled Drop-off Date: <?php echo e($donation->expected_date->format('M d, Y H:i')); ?></p>
        <?php endif; ?>
        

    <?php endif; ?>

    <p>Your support makes a significant difference!</p>

    <p>Thanks,<br>
    Hauz Hayag<br>
    hauzhayag143@gmail.com<br>
    (032) 384 6594</p>
</body>
</html> <?php /**PATH C:\collab\resources\views/emails/donation_received.blade.php ENDPATH**/ ?>