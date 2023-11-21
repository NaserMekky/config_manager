<?php
use Nasermekky\ConfigManager\Controllers\ConfigManager;

if (!function_exists('config_manager')) {
   function config_manager($path){
        
        return (new ConfigManager($path));
    }
}