<?php

namespace Dealskoo\Adserver\Tests;

use Dealskoo\Adserver\Facades\Ad;
use Dealskoo\Adserver\Providers\AdServerServiceProvider;

abstract class TestCase extends \Dealskoo\Admin\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AdServerServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Ad' => Ad::class
        ];
    }
}
