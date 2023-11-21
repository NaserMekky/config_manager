<?php
namespace Nasermekky\Quickadmin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Test extends Controller {
 
/**
$arr = [
    'add_config_key' => true,
    'Naserhr' => 'Naser  Mekky mekky',
    'Naser' => [
        'mohamed' => 'aaaaaaa',
        'ahmed' => 'bbbbbb'

    ]

]
**/

/**
function naser($arr) {
    //dd($arr) ;
    $all = [];
    $dimention = [];
    foreach ($arr as $key => $value) {
        if (is_array($arr[$key])) {
            $dimention[] = $arr[$key];
            naser($dimention);
            //foreach ()
            continue;
        }
        $all[] = $arr[$key];
    }

    return $all;
}
**/
function to_string($array)
{
    $string = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            
            foreach ($value as $key2 => $value2) {
                $string[$key. '.' .$key2] = $value2;
            }
        } else {
            $string[$key]= $value;
        }
    }
    return $string;
}




print_r(to_string(config('app')));


}