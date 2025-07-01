<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CalendarCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function campaigns()
    {
        return $this->hasMany(CalendarCampaign::class, 'category_id');
    }
} 