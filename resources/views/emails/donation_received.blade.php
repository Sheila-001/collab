<!DOCTYPE html>
<html>
<head>
    <title>Donation Received</title>
</head>
<body>
    <p>Dear {{ $donation->donor_name ?? 'Donor' }},</p>

    @if($donation_type === 'monetary')
        <p>Thank you for your generous monetary donation. We have successfully received it.</p>

        <p>Here are the details of your donation:</p>
        <p>Amount: ₱{{ number_format($donation->amount ?? 0, 2) }}</p>
        <p>Date: {{ $donation->created_at?->format('M d, Y h:i A') }}</p>

    @elseif($donation_type === 'non-monetary')
        <p>Thank you for your non-monetary donation. We have confirmed receipt of your generous contribution.</p>
        <p>Here are the details of your donation and confirmation:</p>
        <p>Quantity: {{ $donation->quantity ?? 'N/A' }}</p>
        <p>Category: {{ $donation->category ?? 'N/A' }}</p>
        <p>Item Condition: {{ $donation->condition ?? 'N/A' }}</p>
        @if($donation->expected_date)
            <p>Scheduled Drop-off Date: {{ $donation->expected_date->format('M d, Y H:i') }}</p>
        @endif
        {{-- Add other relevant non-monetary details like condition, category if available --}}

    @endif

    <p>Your support makes a significant difference!</p>

    <p>Thanks,<br>
    Hauz Hayag<br>
    hauzhayag143@gmail.com<br>
    (032) 384 6594</p>
</body>
</html> 