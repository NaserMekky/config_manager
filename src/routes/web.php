<?php

use Illuminate\Support\Facades\Route;
use Nasermekky\ConfigManager\Controllers\ConfigController;

Route::controller(ConfigController::class)->group(function () {
    Route::get('configs', 'index')->name('configs');
    Route::post('configs\getdata', 'getData')->name('configs.getdata');
    Route::post('configs\add', 'store')->name('configs.store');
    Route::post('configs\edit', 'update')->name('configs.update');
    Route::post('configs\delete', 'destroy')->name('configs.delete');
});
