<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'campaign_id',
        'urgent_campaign_id',
        'type', // monetary, non-monetary
        'amount',
        'original_amount',
        'confirmed_amount',
        'item_name',
        'item_category',
        'item_quantity',
        'expected_date',
        'status', // pending, approved, rejected
        'payment_method',
        'payment_status',
        'notes',
        'admin_notes',
        'donor_name',
        'donor_email',
        'donor_phone',
        'is_acknowledged',
        'is_anonymous',
        'proof_path',
        'message',
        'description',
        'condition',
        'category',
        'category_data',
        'quantity',
        'other_item_name',
        'transaction_id',
        'rejection_reason',
        'edited_by',
        'edited_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
        'confirmed_amount' => 'decimal:2',
        'item_quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expected_date' => 'datetime',
        'edited_at' => 'datetime',
        'category_data' => 'array',
    ];

    /**
     * Get the donor that made the donation.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the campaign that received the donation.
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the urgent campaign that received the donation.
     */
    public function urgentCampaign(): BelongsTo
    {
        return $this->belongsTo(UrgentCampaign::class);
    }

    /**
     * Get the user who edited this donation.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    /**
     * Check if this donation has been edited.
     */
    public function hasBeenEdited(): bool
    {
        return !is_null($this->original_amount) && !is_null($this->confirmed_amount);
    }

    /**
     * Get the effective amount (confirmed if edited, otherwise original amount).
     */
    public function getEffectiveAmountAttribute(): float
    {
        return $this->confirmed_amount ?? $this->amount;
    }
} 