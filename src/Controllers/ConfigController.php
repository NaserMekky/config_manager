<?php

namespace Nasermekky\ConfigManager\Controllers;

use App\Http\Controllers\Controller;
use Nasermekky\ConfigManager\Core\GUIConfig;

class ConfigController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            "config_manager::configs.index",
            ['configFiles' => config_manager('app')->configFiles()]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $con = new GUIConfig(request('configName'));
        $success = $con->add(request('key'), request('value'));
        $data = $con->getData();

        return $this->handelResponse("The Key :[ ".request('key')." ] Added Successfully.!", $success, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

        $con = new GUIConfig(request('configName'));
        $success = $con->edit(request('key'), request('value'));
        $data = $con->getData();

        return $this->handelResponse("The Key :[ ".request('key')." ] Edited Successfully.!", $success, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

        $con = new GUIConfig(request('configName'));
        $success = $con->delete(request('key'));
        $data = $con->getData();

        return $this->handelResponse("The Key :[ ".request('key')." ] Deleted Successfully.!", $success, $data);
     }

    public function getData()
    {
        // dd(request('configName'));
        $data = config_manager(request('configName'))->getData();
        return $this->handelResponse("Data Updated Successfully.!", true, $data);
    }

    private function handelResponse($message, $success = true, $data = [])
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ]);
    }

}
