<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Donation;

class MonetaryDonationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;

    /**
     * Create a new message instance.
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Monetary Donation Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.donation_received', // Use the common template
            with: [
                'donation' => $this->donation,
                'donation_type' => 'monetary',
                'donor_name' => $this->donation->donor_name,
                'donation_amount' => $this->donation->amount,
                'donation_date' => $this->donation->created_at?->format('M d, Y h:i A'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
