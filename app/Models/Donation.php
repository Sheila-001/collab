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
        'type', // monetary, non-monetary
        'amount',
        'item_name',
        'item_category',
        'item_quantity',
        'expected_date',
        'status', // pending, approved, rejected
        'payment_method',
        'payment_status',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'item_quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expected_date' => 'datetime',
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
} 