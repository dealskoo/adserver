<?php

namespace Dealskoo\Adserver\Tests\Unit;

use Dealskoo\Adserver\Models\Ad;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdTest extends TestCase
{
    use RefreshDatabase;

    public function test_banner_url()
    {
        $ad = Ad::factory()->create();
        $this->assertNotNull($ad->banner_url);
    }

    public function test_ad_space()
    {
        $ad = Ad::factory()->create();
        $this->assertNotNull($ad->ad_space);
    }

    public function test_avaiabled()
    {
        Ad::factory()->avaiabled()->create();
        $this->assertCount(Ad::avaiabled()->count(), Ad::all());
    }
}
