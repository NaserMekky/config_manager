<?php

namespace Nasermekky\ConfigManager\Core;

use Nasermekky\ConfigManager\Core\Repo;

class GUIConfig extends Repo
{

    public function getData()
    {
        if (file_exists(config_path($this->configName . '.php'))) {
            return $this->flattenArray($this->items);
        }
        throw new \Exception("This File Config\\$this->configName.php Not Found.!");

    }

   
    /**
     * The 'configFiles' method returns a list of all PHP files from the 'config' directory.
     *
     * @return array
     */
    public function configFiles()
    {
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

    /**
     * The 'save' method is responsible for saving the configuration data to the configuration file.
     * It uses the `config` function provided by Laravel and `file_put_contents` to write the configuration file.
     *
     * @return bool
     */

    /*  private function save()
    {
    if (File::put(
    config_path($this->configName . '.php'),
    $this->configToString())) {
    return true;
    }
    return false;
    } */

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

    /*
    private function configToString()
    {
    return '<?php ' . PHP_EOL . ' return '
    . str_replace(['array (', ')'], ['[', ']'],
    var_export($this->items, true)) . ';';
    } */

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
