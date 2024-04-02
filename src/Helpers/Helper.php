<?php

use Nasermekky\ConfigManager\Core\GUIConfig;

if (!function_exists('config_manager')) {
    function config_manager($path)
    {

        return (new GUIConfig($path));
    }
}

