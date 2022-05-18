<?php

namespace Dealskoo\Adserver\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AdSpace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'description'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = Str::upper($value);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
