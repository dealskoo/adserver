<?php

namespace Dealskoo\AdServer\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('adserver.adserver'));
        $this->assertNotNull(PermissionManager::getPermission('ads.index'));
        $this->assertNotNull(PermissionManager::getPermission('ads.show'));
        $this->assertNotNull(PermissionManager::getPermission('ads.create'));
        $this->assertNotNull(PermissionManager::getPermission('ads.edit'));
        $this->assertNotNull(PermissionManager::getPermission('ads.destroy'));

        $this->assertNotNull(PermissionManager::getPermission('ad_spaces.index'));
        $this->assertNotNull(PermissionManager::getPermission('ad_spaces.show'));
        $this->assertNotNull(PermissionManager::getPermission('ad_spaces.create'));
        $this->assertNotNull(PermissionManager::getPermission('ad_spaces.edit'));
        $this->assertNotNull(PermissionManager::getPermission('ad_spaces.destroy'));
    }
}
