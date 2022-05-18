<?php

use Dealskoo\Adserver\Http\Controllers\Admin\AdController;
use Dealskoo\Adserver\Http\Controllers\Admin\AdSpaceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'admin_locale'])->prefix(config('admin.route.prefix'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

    });

    Route::middleware(['auth:admin', 'admin_active'])->group(function () {
        Route::resource('ads', AdController::class);
        Route::resource('ad_spaces', AdSpaceController::class);
    });

});
