<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'address',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public const STATUSES = [
        'scheduled' => 'Scheduled',
        'pending' => 'Pending',
        'done' => 'Done',
        'cancelled' => 'Cancelled',
    ];

    public const CATEGORIES = [
        'feeding' => 'Feeding Program',
        'outreach' => 'Outreach',
        'donation' => 'Donation Drive',
        'medical' => 'Medical Mission',
        'education' => 'Educational Program',
        'other' => 'Other',
    ];

    public function category()
    {
        return $this->belongsTo(CalendarCategory::class);
    }

    /**
     * Scope to get only current and future events (not past events)
     */
    public function scopeCurrentAndFuture($query)
    {
        return $query->where('end_date', '>=', now()->startOfDay());
    }

    /**
     * Scope to get only past events
     */
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now()->startOfDay());
    }

    /**
     * Scope to get events by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get active events (scheduled or pending, not cancelled or done)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['scheduled', 'pending']);
    }

    /**
     * Check if the event is currently active (not past and not cancelled)
     */
    public function isActive(): bool
    {
        return $this->end_date >= now()->startOfDay()
            && in_array($this->status, ['scheduled', 'pending']);
    }

    /**
     * Check if the event is past its end date
     */
    public function isPast(): bool
    {
        return $this->end_date < now()->startOfDay();
    }

    /**
     * Get the event's computed status based on dates and current status
     */
    public function getComputedStatusAttribute(): string
    {
        if ($this->isPast() && $this->status !== 'cancelled') {
            return 'completed';
        }
        return $this->status;
    }
}