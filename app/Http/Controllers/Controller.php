<?php

namespace App\Http\Controllers;

use App\Models\LSP\Users;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PhpParser\Builder\Class_;
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
        if ($this->getDeleteClass() == null) return view('errors.500', ['message' => 'getDeleteMethod required']);
        $request->validate([
            "Id" => "required"
        ]);
        $deletedRecord = $this->getDeleteClass()::destroy($request->get('Id'));
        if ($deletedRecord) return $deletedRecord;
        else return abort(500);
    }
}
