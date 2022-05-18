<?php

namespace Dealskoo\Adserver;

use Dealskoo\Adserver\Models\AdSpace;

class Ad
{
    public function get($code)
    {
        $ad_space = AdSpace::where('code', $code)->first();
        return $ad_space->ads()->avaiabled()->orderBy('id')->first();
    }
}
