<?php

namespace Dealskoo\Adserver\Tests\Unit;

use Dealskoo\Adserver\Models\Ad;
use Dealskoo\Adserver\Models\AdSpace;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class AdSpaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_code()
    {
        $code = 'Test';
        $ad_space = AdSpace::factory()->create();
        $ad_space->code = $code;
        $this->assertEquals(Str::upper($code), $ad_space->code);
    }

    public function test_ads()
    {
        $ad_space = AdSpace::factory()->create();
        $ad = Ad::factory()->create();
        $ad_space->ads()->save($ad);
        $this->assertCount(1, $ad_space->ads);
    }
}
