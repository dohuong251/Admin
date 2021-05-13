<?php

namespace App\Http\Controllers;

use App\Models\ReportRule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use View;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if ($this->getViewShareArray() != null && is_array($this->getViewShareArray())) {
            foreach ($this->getViewShareArray() as $key => $value) {
                View::share($key, $value);
            }
        }

        $ruleCheckingNotifications = ReportRule::whereIn("status", [2, 3])->orderByDesc("status")->orderByDesc("created_at")->get();
        View::share("notifications", $ruleCheckingNotifications);
//        $GLOBALS["parse_rule_checking"] = true;
//        Artisan::call("check:rules", []);
//        $parseRuleReport
//        View::share();
    }


    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    abstract protected function getViewShareArray();

    /**
     * @return model sẽ thực hiện xóa hàng loạt trong hàm delete
     */
    abstract protected function getDeleteClass();

    // xóa hàng loạt bản ghi (request ajax)
    public function delete(Request $request)
    {
        if ($this->getDeleteClass() == null) return response('getDeleteClass required', 500);
        $request->validate([
            "Id" => "required"
        ]);
        $deletedRecord = $this->getDeleteClass()::destroy($request->get('Id'));
        if ($deletedRecord) return $deletedRecord;
        else return abort(500);
    }
}
