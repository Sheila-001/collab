<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'goal_amount',
        'funds_raised',
        'status',
        'image',
        'start_date',
        'end_date',
        'category_id',
        'pledged_amount',
        'pledged_quantity',
        'color',
        'total_donations',
        'is_urgent',
        'is_archived'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_urgent' => 'boolean',
        'is_archived' => 'boolean',
        'goal_amount' => 'decimal:2',
        'funds_raised' => 'decimal:2',
        'total_donations' => 'decimal:2'
    ];

    /**
     * Get all donations for this campaign
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Calculate the progress percentage of the campaign
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }
        return min(($this->total_donations / $this->goal_amount) * 100, 100);
    }

    /**
     * Get the campaign's computed status based on dates and progress
     * This is different from the database 'status' field
     */
    public function getComputedStatusAttribute(): string
    {
        if ($this->is_archived) {
            return 'archived';
        }
        if ($this->end_date < now()) {
            return 'ended';
        }
        if ($this->progress_percentage >= 100) {
            return 'completed';
        }
        if ($this->start_date > now()) {
            return 'scheduled';  // ✅ Campaign hasn't started yet
        }
        return 'active';
    }

    /**
     * Check if campaign is currently accepting donations
     */
    public function isAcceptingDonations(): bool
    {
        return $this->status === 'active'
            && $this->start_date <= now()        // ✅ Must have started
            && $this->end_date > now()           // ✅ Must not have ended
            && !$this->is_archived
            && $this->progress_percentage < 100;
    }

    /**
     * Check if campaign is scheduled (before start date)
     */
    public function isScheduled(): bool
    {
        return $this->status === 'active'
            && $this->start_date > now()
            && !$this->is_archived;
    }

    /**
     * Check if campaign is currently running (between start and end date)
     */
    public function isRunning(): bool
    {
        return $this->status === 'active'
            && $this->start_date <= now()
            && $this->end_date > now()
            && !$this->is_archived;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope to get only active campaigns that are accepting donations
     */
    public function scopeAcceptingDonations($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())  // ✅ Must have started
                    ->where('end_date', '>', now())     // ✅ Must not have ended
                    ->where('is_archived', false);
    }

    /**
     * Update the total donations for this campaign - use effective amount
     */
    public function updateTotalDonations(): void
    {
        $this->total_donations = $this->donations()
            ->where('type', 'monetary')
            ->where('status', 'approved')
            ->get()
            ->sum('effective_amount');
        $this->save();
    }
}
