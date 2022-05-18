<?php

namespace Dealskoo\Adserver\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Adserver\Models\AdSpace;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdSpaceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ad_spaces.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ad_spaces.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad_space = AdSpace::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ad_spaces.show', $ad_space));
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ad_spaces.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad_space = AdSpace::factory()->make();
        $response = $this->actingAs($admin, 'admin')->post(route('admin.ad_spaces.store'), $ad_space->only([
            'code',
            'description'
        ]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad_space = AdSpace::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ad_spaces.edit', $ad_space));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad_space = AdSpace::factory()->create();
        $ad_space1 = AdSpace::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.ad_spaces.update', $ad_space), $ad_space1->only([
            'code',
            'description'
        ]));
        $response->assertStatus(302);
        $ad_space->refresh();
        $this->assertEquals($ad_space->code, $ad_space1->code);
    }

    public function test_destroy()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad_space = AdSpace::factory()->create();
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.ad_spaces.destroy', $ad_space));
        $response->assertStatus(200);
        $this->assertSoftDeleted($ad_space);
    }
}
