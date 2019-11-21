<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Models\Tool\Config;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

class ConfigController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->has(['id_application', 'device'])) {
            // ajax request lấy thông tin config của app cụ thể
            return [
                'id' => $request->get('id_application'),
                'data' => Config::select(['name', 'value'])->where([
                    ['id_application', $request->get('id_application')],
                    ['device', $request->get('device')]
                ])->get(),
                'device' => $request->get('device')
            ];
        } else {
            // giao diện request thông thường
            return view('tools.config', [
                'configApps' => Config::distinct()->get('id_application'),

            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            "id" => "required|string",
            "config" => "nullable|array",
            "device" => "required|numeric"
        ]);
        $appId = $request->get('id');

        // remove old config if exist
        Config::where([['id_application', $appId], ['device', $request->get("device")]])->delete();

        $config = $request->get('config');
        if ($config) {
            if (!$this->insertNewConfig($appId, $request->get("device"), $config)) {
                return abort(500);
            }
        }
        return response($appId);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required|string",
            "config" => "nullable|array",
            "device" => "required|numeric"
        ]);
        $appId = $request->get('id');

        $appConfig = Config::where([['id_application', $appId], ['device', $request->get("device")]]);
        if (!$appConfig) return response("App Not Found", 400);
        $appConfig->delete();

        $config = $request->get('config');
        if ($config) {
            if (!$this->insertNewConfig($appId, $request->get("device"), $config)) {
                return abort(500);
            }
        }
        return response($appId);
    }

    /**
     * @param $appId : application id
     * @param $device : application device (0 - Google, 1 - Amazon, 2 - SamSung, 3 - MDC, 4 -AppleTV)
     * @param $config : config array (example: [["name"=>"ads","value"=>"ads_value"], ["name"=>"version","value"=>"1.0"]]
     * @return Boolean
     */
    function insertNewConfig($appId, $device, $config)
    {
        foreach ($config as &$pair) {
            $pair["id_application"] = $appId;
            $pair["device"] = $device;
            if ($pair["value"] == null) $pair["value"] = "";
        }

        return Config::insert($config);
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return null;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return null;
    }
}
