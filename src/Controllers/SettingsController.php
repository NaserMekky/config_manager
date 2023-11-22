<?php

namespace Nasermekky\ConfigManager\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller {

    private $message;
    /**
    * Display a listing of the resource.
    */
    public function index() {
        return view("config_manager::settings.index", [
            'settings' => config_manager('quickadmin')->all(),
            "message" => $this->message,
            'options' => config_manager('quickadmin')->configFiles()
        ]);
    }


    /**
    * Show the form for creating a new resource.
    */
    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request) {
        
       return back()->with('message', config_manager('quickadmin')
        ->add(request('key'), request('value')));
    
    }

    /**
    * Display the specified resource.
    */
    public function show(string $key) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $key) {
        $data['key'] = $key;
        $data['value'] = config('quickadmin.'.$key);

        return view('quickadmin::settings.edit', $data);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, string $key) {
    
  return back()->with('message', config_manager('quickadmin')->edit($key, request('value')));
       
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $key) {
       
return back()->with('message', config_manager('quickadmin')->destroy($key));
        
    }

    private function configToString($configPath) {
        return '<?php '.PHP_EOL.' return '
        .str_replace(['array (', ')'], ['[', ']'],
            var_export(config($configPath), true)). ';';
    }

    public function array_to_table($array) {
        $table = '<table border="1">';
        array_walk_recursive($array,
            function($item, $key) use (&$table) {
                $table .= "<tr><td>$key</td><td>$item</td></tr>";
            }
        );
        $table .= '</table>';
        return $table;
    }


    public function flattenArray($array, $prefix = '') {
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








}