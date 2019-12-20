<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Sale\LicenseKey;
use Config;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    //
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'PurchaseDate');
        $order = $request->get('order', 'desc');

        $searchQuery = LicenseKey::orderBy($sort, $order);
        if ($request->get("query") != null) {
            $searchQuery->where($request->get("searchType"), 'like', "%" . $request->get('query') . "%");
        }

        if ($request->get("appid") != null) {
            $searchQuery->where('ApplicationId', $request->get("appid"));
        }

        if ($request->get('state') != null) {
            $searchQuery->where("State", $request->get('state'));
        }

        return view('sales.license', [
            'licenseKeys' => $searchQuery->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'))->appends(Request()->except('page')),
            'sort' => $sort,
            'order' => $order,
        ]);
    }

    public function destroy($licenseId)
    {
        if(LicenseKey::destroy($licenseId)){
            return response(null);
        } else {
            return response("Xóa license $licenseId thất bại", 500);
        }
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
