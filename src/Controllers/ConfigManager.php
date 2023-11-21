<?php

namespace Nasermekky\ConfigManager\Controllers;

class ConfigManager {
    private $configData = [];
    private $configName;
    private $message = [];

    public function __construct($name) {
        $this->configName = $name;
    }

    public function all() {

        if (file_exists(config_path($this->configName. '.php'))) {

            return $this->flattenArray(config($this->configName));
        }

        $this->message['error'] = "This File Not Found..";
        return $this->message;
    }

    public function add($key, $value) {
        if ($this->key_exist($key)) {
            $this->message['error'] = "Sorry! This [ $key ] Is Existing Before.";
            return $this->message;
        } else {
            $this->configData[$this->configName. '.' .$key] = $value;
            if ($this->save()) {
                $this->message['success'] = "Add Successfully!";
                return $this->message;
            }
        }
    }

    public function edit($key, $value) {
        if ($this->key_exist($key)) {
            $this->configData[$this->configName. '.' .$key] = $value;
            if ($this->save()) {
                $this->message['success'] = "Edit Successfully!";
                return $this->message;
            }
        } else {
            $this->message['error'] = "This Key : [ $key ] Not Exists!";
            return $this->message;
        }

    }



    public function destroy(string $key) {

        if ($this->key_exist($key)) {
            $con = $this->all();
            unset($con[$key]);
           // dd($con);
            file_put_contents(
                config_path($this->configName.'.php'),
                $this->configToString($con));
            $this->message['success'] = "This Key :[ $key ] Deleted Successfully!";
            return $this->message;
        } else {
            $this->message['error'] = "This Key :[ $key ] Not Exists!";
            return $this->message;
        }

    }

    public function configFiles() {

        // Get a list of all files in the config directory
        $files = glob(config_path('*.php'));

        // Convert the file names to options for a select form
        return array_map(function ($file) {
            return [
                'value' => $file,
                'text' => basename($file, '.php'),
            ];
        }, $files);

    }
    private function save() {
        config($this->configData);
        if (file_put_contents(
            config_path($this->configName.'.php'),
            $this->configToString())) {
            return TRUE;
        }
        return FALSE;
    }

    private function flattenArray($array, $prefix = '') {
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $prefix . $key . '.'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        return $result;
    }


    private function configToString($configName = NULL) {
        return '<?php '.PHP_EOL.' return '
        .str_replace(['array (', ')'], ['[', ']'],
            var_export($configName ?? config($this->configName), true)). ';';
    }

    private function key_exist($key) {
        return array_key_exists(
            $key,
            $this->flattenArray(
                config($this->configName)));

    }
}