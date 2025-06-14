@component('mail::message')
# Your Non-Monetary Donation Drop-off Has Been Confirmed!

Dear {{ $donation->donor_name }},

We are pleased to inform you that your non-monetary donation submission to Hauz Hayag Scholarship has been reviewed and your drop-off arrangement has been confirmed.

**Item Details:**
- **Category:** {{ $donation->category }}
- **Condition:** {{ $donation->condition }}
- **Quantity:** {{ $donation->quantity }} {{ $donation->quantity > 1 ? 'units' : 'unit' }}
- **Description/Notes:** {{ $donation->notes }}

**Drop-off Details:**
- **Confirmed Date & Time:** {{ $donation->expected_date->format('M d, Y g:i A') }}
- **Location:** Carlock Street, San Nicolas Proper, 6000 Cebu City, Philippines

Please bring your donation to the specified address at the confirmed date and time.

Your generosity is greatly appreciated and makes a real difference in the lives of our scholars.

If you have any questions or need to reschedule, please contact us immediately.

Thanks,
{{ config('app.name') }}
@endcomponent 