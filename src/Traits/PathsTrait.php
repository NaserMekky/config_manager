<?php

namespace Nasermekky\Quickadmin\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PathsTrait
{


    /**
     * Returned The Defualt Path For FullPath\app\Models
     * Or Custom Another Path.
     * @param  string  $custum_path
     * @return string
     */
    public function model_path($custum_path = null)
    {
        if ($custum_path != null) {

            return app_path($custum_path);
        }
        return app_path('Models/');
    }

    /**
     * Returned The Defualt Path For FullPath\app\Http\Controller
     * Or Custom Another Path.
     * @param  string  $custum_path
     * @return string
     */
    public function controller_path($custum_path = null)
    {
        if ($custum_path != null) {

            return app_path($custum_path);
        }
        return app_path('Http/Controllers/');
    }

    /**
     * Returned The Defualt Path For FullPath\app\Http\Requests
     * Or Custom Another Path.
     * @param  string  $custum_path
     * @return string
     */
    public function request_path($custum_path = null)
    {
        if ($custum_path != null) {

            return base_path($custum_path);
        }
        return app_path('Http/Requests/');
    }

    /**
     * Returned The Defualt Path For FullPath\database\migrations
     * Or Custom Another Path.
     * @param  string  $custum_path
     * @return string
     */
    public function migration_path($custum_path = null)
    {
        if ($custum_path != null) {

            return base_path($custum_path);
        }
        return database_path('migrations/');
    }

    /**
     * Returned The Defualt Path For FullPath\database\factories
     * Or Custom Another Path.
     * @param  string  $custum_path
     * @return string
     */
    public function factory_path($custum_path = null)
    {
        if ($custum_path != null) {

            return base_path($custum_path);
        }
        return database_path('factories/');
    }

    /**
     * Returned The Defualt Path For FullPath\database\seeders
     * Or Custom Another Path.
     * @param  string  $custum_path
     * @return string
     */
    public function seeder_path($custum_path = null)
    {
        if ($custum_path != null) {

            return base_path($custum_path);
        }
        return database_path('seeders/');
    }
}
