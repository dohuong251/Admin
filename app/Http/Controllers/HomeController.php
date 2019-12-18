<?php

namespace App\Http\Controllers;

use App\Models\Lsp\Songs;
use App\Models\Sale\LicenseKey;
use App\Models\Sale\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lspOrders = Order::select('PurchaseMethod', DB::raw('count(*) as Total'))->whereIn('ApplicationId', ["Live Media Player", "Live Stream Player", "Live Stream Player AndroidTV"])->groupBy('PurchaseMethod')->get()->toArray();
        foreach ($lspOrders as &$lspOrder) {
            if ($lspOrder["PurchaseMethod"] == 6) {
                //license key
                $lspOrder["Total"] = LicenseKey::whereIn('ApplicationId', ["Live Media Player", "Live Stream Player", "Live Stream Player AndroidTV"])->count();
            }
        }
        return view('home', [
            "LspOrder" => $lspOrders,
            "USTVOrder" => Order::select('PurchaseMethod', DB::raw('count(*) as Total'))->where('ApplicationId', "USTV")->groupBy('PurchaseMethod')->get(),
        ]);
    }

    public function filter(Request $request)
    {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

//        'SELECT COUNT(*) AS `Hàng`, `PurchaseMethod`, PurchaseDate FROM `orders` where PurchaseDate BETWEEN "2019-12-01" AND "2019-12-18" GROUP BY DATE(PurchaseDate), PurchaseMethod ORDER BY `PurchaseDate`'

        $lspOrders = Order::select('PurchaseMethod', 'PurchaseDate', DB::raw('count(*) as Total'))
            ->whereIn('ApplicationId', ["Live Media Player", "Live Stream Player", "Live Stream Player AndroidTV"])
            ->whereBetween('PurchaseDate', [$startDate, $endDate])
            ->groupBy('PurchaseMethod')
            ->groupBy(DB::raw('DATE(PurchaseDate)'))
            ->orderBy('PurchaseDate')
            ->get()
            ->toArray();
        foreach ($lspOrders as &$lspOrder) {
            if ($lspOrder["PurchaseMethod"] == 6) {
                //license key
                $lspOrder["Total"] = LicenseKey::whereBetween('PurchaseDate', [$startDate, $endDate])->whereIn('ApplicationId', ["Live Media Player", "Live Stream Player", "Live Stream Player AndroidTV"])->groupBy('PurchaseMethod')->count();
            }
        }
        return array(
            "LspStream" => array(
                "LastOnline" => Songs::whereBetween('LastOnline', [$startDate, $endDate])
                    ->selectRaw('LastOnline as Date, count(*) as Total')
                    ->groupBy('LastOnline')
                    ->orderBy('LastOnline', 'asc')
                    ->get(),
                "Published" => Songs::whereBetween('PublishedDate', [$startDate, $endDate])
                    ->selectRaw('PublishedDate as Date, count(*) as Total')
                    ->groupBy('PublishedDate')
                    ->orderBy('PublishedDate', 'asc')
                    ->get()),
            "LspOrder" => $lspOrders,
//            "USTVOrder" => Order::select('PurchaseMethod', DB::raw('count(*) as Total'))
//                ->where('ApplicationId', "USTV")
//                ->whereBetween('PurchaseDate', [$startDate, $endDate])
//                ->groupBy('PurchaseMethod')
//                ->get(),
            "USTVOrder" => Order::select('PurchaseMethod', 'PurchaseDate', DB::raw('count(*) as Total'))
                ->where('ApplicationId', "USTV")
                ->whereBetween('PurchaseDate', [$startDate, $endDate])
                ->groupBy('PurchaseMethod')
                ->groupBy(DB::raw('DATE(PurchaseDate)'))
                ->orderBy('PurchaseDate')
                ->get(),
        );
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return null;
    }

    /**
     * @return model sẽ thực hiện xóa hàng loạt trong hàm delete
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return null;
    }
}
