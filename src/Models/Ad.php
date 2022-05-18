<?php

namespace Dealskoo\Adserver\Models;

use Carbon\Carbon;
use Dealskoo\Country\Traits\HasCountry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Ad extends Model
{
    use HasFactory, SoftDeletes, HasCountry;

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

    public function scopeAvaiabled(Builder $builder)
    {
        $now = Carbon::now();
        return $builder->where('start_at', '<=', $now)->where('end_at', '>=', $now);
    }
}
