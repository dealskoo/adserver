<?php

namespace Dealskoo\Adserver\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description'
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
