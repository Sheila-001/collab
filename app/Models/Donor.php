<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'type', // individual, organization, etc.
        'status', // active, inactive
    ];

    /**
     * Get the donations for the donor.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the total amount donated by this donor - use effective amount.
     */
    public function getTotalDonatedAttribute()
    {
        return $this->donations()
            ->where('type', 'monetary')
            ->get()
            ->sum('effective_amount');
    }

    /**
     * Get the total number of donations made by this donor.
     */
    public function getDonationCountAttribute()
    {
        return $this->donations()->count();
    }
} 