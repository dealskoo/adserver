<?php

namespace Dealskoo\Adserver\Tests\Feature\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Models\Admin;
use Dealskoo\Adserver\Models\Ad;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class AdControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ads.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ads.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad = Ad::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ads.show', $ad));
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ads.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad = Ad::factory()->make();
        $response = $this->actingAs($admin, 'admin')->post(route('admin.ads.store'), Arr::collapse([$ad->only([
            'title',
            'link',
            'country_id',
            'ad_space_id',
        ]), [
            'banner' => UploadedFile::fake()->image('file.jpg'),
            'activity_date' => Carbon::parse($ad->start_at)->format('m/d/Y') . ' - ' . Carbon::parse($ad->end_at)->format('m/d/Y')
        ]]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad = Ad::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.ads.edit', $ad));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad = Ad::factory()->create();
        $ad1 = Ad::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.ads.update', $ad), Arr::collapse([$ad1->only([
            'title',
            'link',
            'country_id',
            'ad_space_id',
        ]), [
            'banner' => UploadedFile::fake()->image('file.jpg'),
            'activity_date' => Carbon::parse($ad1->start_at)->format('m/d/Y') . ' - ' . Carbon::parse($ad1->end_at)->format('m/d/Y')
        ]]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $admin = Admin::factory()->isOwner()->create();
        $ad = Ad::factory()->create();
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.ads.destroy', $ad));
        $response->assertStatus(200);
        $this->assertSoftDeleted($ad);
    }
}
