<?php

namespace Dealskoo\Adserver\Models;

use Dealskoo\Country\Traits\HasCountry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ad extends Model
{
    use HasFactory, HasCountry;

    protected $appends = [
        'banner_url'
    ];

    protected $fillable = [
        'title',
        'banner',
        'link',
        'ad_space_id',
        'country_id',
        'views',
        'clicks',
        'start_at',
        'end_at'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function getBannerUrlAttribute()
    {
        return Storage::url($this->banner);
    }

    public function ad_space()
    {
        return $this->belongsTo(AdSpace::class);
    }
}
