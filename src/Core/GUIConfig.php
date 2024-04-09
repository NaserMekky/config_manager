<?php

namespace Nasermekky\ConfigManager\Core;

use Illuminate\Support\Facades\File;
use Nasermekky\ConfigManager\Core\Repo;

class GUIConfig extends Repo
{

    public function getData()
    {
        if (file_exists($this->path)) {
            return $this->flattenArray($this->items);
        }
        throw new \Exception("This File [ $this->path ] Not Found.!");
    }


    /**
     * The 'configFiles' method returns a list of all PHP files from the 'config' directory.
     *
     * @return array
     */
    public function configFiles()
    {
        // Get a list of all files in the config directory
        $files = File::allFiles(config_path());

        // Convert the file names to options for a select form
        return array_map(function ($file) {
            $slice =  array_slice(explode('/', $file->getPathname()), -2, 2);
            return [
                'text' => $slice[0] . '/' . basename($slice[1], '.php'),
                'value' => $file->getPathname(),
            ];
        }, $files);
    }

    /**
     * The 'langFiles' method returns a list of all PHP files from the 'lang' directory.
     *
     * @return array
     */
    public function langFiles()
    {
        // Get a list of all files in the lang directory
        $files = File::allFiles(lang_path());

        // Convert the file names to options for a select form
        return array_map(function ($file) {
            $slice =  array_slice(explode('/', $file->getPathname()), -2, 2);
            return [
                'text' => $slice[0] . '/' . basename($slice[1], '.php'),
                'value' => $file->getPathname(),
            ];
        }, $files);
    }
    /**
     * The 'flattenArray' method takes an array and recursively
     * converts it into a single-dimensional array.
     *
     * @param array $array
     * @param string $prefix
     *
     * @return array
     */
    private function flattenArray($array, $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $prefix . $key . '.'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        return $result;
    }

    /**
     * Create a response array
     * @param string $message
     * @param bool $success
     * @param array $data
     * @return array
     */
    private function responseToArray($message, $success = false, $data = [])
    {
        return [
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ];
    }
}
