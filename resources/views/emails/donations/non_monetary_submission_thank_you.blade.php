@component('mail::message')
# Thank You for Your Non-Monetary Donation Submission!

Dear {{ $donation->donor_name }},

Thank you for your non-monetary donation submission to Hauz Hayag Scholarship. We have received your submission and it is now awaiting review by our organization.

**Item Details:**
- **Category:** {{ $donation->category }}
- **Condition:** {{ $donation->condition }}
- **Quantity:** {{ $donation->quantity }} {{ $donation->quantity > 1 ? 'units' : 'unit' }}
- **Description/Notes:** {{ $donation->notes }}
- **Expected Drop-off Date:** {{ $donation->expected_date->format('M d, Y g:i A') }}

We appreciate your generosity. Our team will review your donation details and get back to you with a confirmation for drop-off arrangement within 24-48 hours. Please do not drop off the item until you receive a confirmation email from us.

If you have any questions, please do not hesitate to contact us.

Thanks,
{{ config('app.name') }}
@endcomponent 