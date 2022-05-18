<?php

namespace Dealskoo\AdServer\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Adserver\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'adserver::adserver.adserver'));
        $childs = AdminMenu::findBy('title', 'adserver::adserver.adserver')->getChilds();
        $menu = collect($childs)->where('title', 'adserver::adserver.ads');
        $this->assertNotEmpty($menu);
        $menu = collect($childs)->where('title', 'adserver::adserver.ad_spaces');
        $this->assertNotEmpty($menu);
    }
}
