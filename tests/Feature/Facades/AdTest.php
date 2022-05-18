<?php

namespace Dealskoo\Adserver\Tests\Feature\Facades;

use Dealskoo\Adserver\Facades\Ad;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdTest extends TestCase
{
    use RefreshDatabase;

    public function test_get()
    {
        $ad = \Dealskoo\Adserver\Models\Ad::factory()->avaiabled()->create();
        $ad1 = Ad::get($ad->ad_space->code);
        $this->assertEquals($ad->title, $ad1->title);
    }
}
