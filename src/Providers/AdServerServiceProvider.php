<?php

namespace Dealskoo\Adserver\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Illuminate\Support\ServiceProvider;

class AdServerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/adserver')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'adserver');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'adserver');

        AdminMenu::dropdown('adserver::adserver.adserver', function ($menu) {
            $menu->route('admin.ads.index', 'adserver::adserver.ads', [], ['permission' => 'ads.index']);
            $menu->route('admin.ad_spaces.index', 'adserver::adserver.ad_spaces', [], ['permission' => 'ad_spaces.index']);
        }, ['icon' => 'uil-google', 'permission' => 'adserver.adserver'])->order(99);

        PermissionManager::add(new Permission('adserver.adserver', 'Ad Server'));
        PermissionManager::add(new Permission('ads.index', 'Ad List'), 'adserver.adserver');
        PermissionManager::add(new Permission('ads.show', 'View Ad'), 'ads.index');
        PermissionManager::add(new Permission('ads.create', 'Create Ad'), 'ads.index');
        PermissionManager::add(new Permission('ads.edit', 'Edit Ad'), 'ads.index');
        PermissionManager::add(new Permission('ads.destroy', 'Destroy Ad'), 'ads.index');

        PermissionManager::add(new Permission('ad_spaces.index', 'Ad Spaces List'), 'adserver.adserver');
        PermissionManager::add(new Permission('ad_spaces.show', 'View Ad Space'), 'ad_spaces.index');
        PermissionManager::add(new Permission('ad_spaces.create', 'Create Ad Space'), 'ad_spaces.index');
        PermissionManager::add(new Permission('ad_spaces.edit', 'Edit Ad Space'), 'ad_spaces.index');
        PermissionManager::add(new Permission('ad_spaces.destroy', 'Destroy Ad Space'), 'ad_spaces.index');
    }
}
