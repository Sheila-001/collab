<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class UrgentCampaign extends Model
{
    protected $fillable = [
        'title',
        'description',
        'goal_amount',
        'current_amount',
        'is_active',
        'ends_at',
    ];

    protected $casts = [
        'ends_at' => 'datetime',
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    /**
     * Get the donations for this urgent campaign.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get only approved donations for this urgent campaign.
     */
    public function approvedDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', 'approved');
    }

    /**
     * Get only completed donations for this urgent campaign (for drop-off management).
     */
    public function completedDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', 'completed');
    }

    /**
     * Calculate total donations from approved donations only - use effective amount.
     */
    public function getTotalDonationsAttribute(): float
    {
        return $this->approvedDonations()
            ->where('type', 'monetary')
            ->get()
            ->sum('effective_amount') ?? 0.00;
    }

    /**
     * Calculate progress percentage based on approved donations.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }

        return min(($this->total_donations / $this->goal_amount) * 100, 100);
    }

    /**
     * Get the campaign's computed status based on end date and progress.
     */
    public function getComputedStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }
        if ($this->ends_at && $this->ends_at < now()) {
            return 'ended';
        }
        if ($this->progress_percentage >= 100) {
            return 'completed';
        }
        return 'active';
    }

    /**
     * Check if campaign is currently accepting donations.
     */
    public function isAcceptingDonations(): bool
    {
        return $this->is_active
            && (!$this->ends_at || $this->ends_at > now())
            && $this->progress_percentage < 100;
    }

    /**
     * Scope to get only campaigns accepting donations.
     */
    public function scopeAcceptingDonations($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                    });
    }

    /**
     * Update the current_amount based on completed donations.
     */
    public function updateTotalDonations(): void
    {
        $this->current_amount = $this->total_donations;
        $this->save();
    }
}
