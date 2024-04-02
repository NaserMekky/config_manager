<?php

namespace Nasermekky\ConfigManager\Core;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Repo extends Repository
{

    // Define the configName property, which will store the name of the configuration
    protected $configName;

    /**
     * The constructor of the Repo class, which takes a configName parameter to initialize the configName property.
     * It also calls the parent constructor with the configuration data of the given configName.
     *
     * @param string $configName
     */
    public function __construct($configName)
    {
        $this->configName = $configName;
        parent::__construct(Config::get($configName, []));
    }
    /**
     * The add method, which adds a new key-value pair to the configuration data.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     * @throws \Exception
     */
    public function add($key, $value)
    {
        if (!$this->has($key)) {
            $this->set($key, $this->is_boolean($value));
            if ($this->save()) {
                return true;
            } else {
                throw new \Exception(sprintf("Sorry! Something Went Wrong  Before Save The Key:[ %s ] .!", $key));
            }
        }

        throw new \Exception(sprintf("Sorry! The Key :[ %s ] Is Existing Before.!", $key));
    }

    /**
     * The edit method, which edits an existing key-value pair in the configuration data.
     * It checks if the key exists, and if it does, it edits the key-value pair and saves the configuration data.
     * If the configuration data is saved successfully, it returns true.
     * If the key does not exist, it throws an exception.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     * @throws \Exception
     */
    public function edit($key, $value)
    {
        if ($this->has($key)) {
            $this->set($key, $this->is_boolean($value));
            if ($this->save()) {
                return true;
            } else {
                throw new \Exception(sprintf("Sorry! Something Went Wrong  Before Save The Key:[ %s ] .!", $key));
            }
        }

        throw new \Exception(sprintf("Sorry! The Key :[ %s ] Not Exists.!", $key));
    }

    /**
     * The delete method, which deletes an existing key-value pair from the configuration data.
     *
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function delete(string $key)
    {
        if ($this->has($key)) {
            $this->unset($key);
            if ($this->save()) {
                return true;
            }
        }

        throw new \Exception(sprintf("Sorry! The Key :[ %s ] Not Exists.!", $key));
    }

    /**
     * The unset method, which unsets an existing key-value pair from the configuration data.
     *
     * @param string $key
     */
    private function unset($key)
    {
        Arr::forget($this->items, $key);
    }

    /**
     * The configToString method, which converts the configuration data to a string representation.
     * It returns a string representation of the configuration data, which can be written to a file.
     *
     * @return string
     */
    private function configToString()
    {
        return '<?php ' . PHP_EOL . ' return '
        . str_replace(
            ['array (', ')'],
            ['[', ']'],
            var_export($this->items, true)
        ) . ';';
    }

    /**
     * The 'save' method is responsible for saving the configuration data to the configuration file.
     *
     * @return bool
     */
    private function save()
    {
        if (File::put(
            config_path($this->configName . '.php'),
            $this->configToString()
        )) {
            return true;
        }
        return false;
    }

    private function is_boolean($value){
        if (preg_match('/^(true|1)$/i', $value)) {
            return true;
        }elseif (preg_match('/^(false|0)$/i', $value)) {
            return false;
        }elseif (preg_match('/^(null)$/i', $value)) {
            return null;
        }
        return $value;
    }
}
