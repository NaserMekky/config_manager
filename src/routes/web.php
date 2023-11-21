<?php

use Illuminate\Support\Facades\Route;
use Nasermekky\ConfigManager\Controllers\SettingsController;
use Nasermekky\Quickadmin\Controllers\Config;
use Nasermekky\ConfigManager\Controllers\ConfigManager;



Route::resource("settings", SettingsController::class);

Route::get('config', function () {
    
   // dd($n ?? 'naser');
    $n = config_manager('quickadmin')->all();
    unset($n['one.one_three']);
    dd($n);

    
});