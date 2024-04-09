<?php

namespace Nasermekky\ConfigManager\Core;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Repo extends Repository
{

    // Define the path of the configuration
    protected $path;

    /**
     * The constructor of the Repo class, which takes a path parameter to initialize the path property.
     * It also calls the parent constructor with the configuration data of the given path.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = str_ends_with($path, '.php') ? $path : $path . '.php';
        parent::__construct(require($this->path));
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
     * It edits an existing key-value pair in the configuration data.
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
     * It deletes an existing key-value pair from the configuration data.
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
     * Unset a configuration option.
     *
     * @param string $key
     */
    private function unset($key)
    {
        Arr::forget($this->items, $key);
    }

    /**
     * The configToString method, which converts the configuration data to a string representation.
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
        // dd($this->path);
        if (file_put_contents(
            $this->path,
            $this->configToString()
        )) {
            return true;
        }
        return false;
    }

    private function is_boolean($value)
    {
        if (preg_match('/^(true|1)$/i', $value)) {
            return true;
        } elseif (preg_match('/^(false|0)$/i', $value)) {
            return false;
        } elseif (preg_match('/^(null)$/i', $value)) {
            return null;
        }
        return $value;
    }
}
