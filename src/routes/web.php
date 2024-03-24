<?php

use Illuminate\Support\Facades\Route;
use Nasermekky\ConfigManager\Controllers\SettingsController;
use Nasermekky\Quickadmin\Controllers\Config;
use Nasermekky\ConfigManager\Controllers\ConfigManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

Route::group(['middleware' => ['web']], function () {

    Route::resource('settings', SettingsController::class);

    Route::get('config', function () {
        return view("config_manager::settings.index2",
            ['options' => config_manager('quickadmin')->configFiles()]
        );
    }
    );

    Route::post('naser', [SettingsController::class, 'index'])->name('naser');
    Route::post('naser/update', [SettingsController::class, 'update'])->name('naser.update');
    Route::post('naser/delete', [SettingsController::class, 'destroy'])->name('naser.delete');
    Route::post('naser/create', [SettingsController::class, 'store'])->name('naser.store');
    Route::get('test', function () {
        $start = date_create("1992-11-29");
        $end = date_create("2024-2-28");
        $diff = date_diff($end,$start);
        
        echo $diff->y ." year/s,"
            .$diff->m ." month/s, "
            .$diff->d ." day/s.";
         
    });




});