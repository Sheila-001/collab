<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
