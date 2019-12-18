<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Sale\Customer;
use App\Models\Sale\LicenseKey;
use App\Models\Sale\Order;
use Config;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'PurchaseDate');
        $order = $request->get('order', 'desc');

        $searchQuery = Customer::selectRaw('customers.*, count(orders.OrderId) as totalOrders, orders.PurchaseDate, GROUP_CONCAT(DISTINCT(orders.ApplicationId) SEPARATOR ", ") as "ApplicationPurchases", GROUP_CONCAT(DISTINCT(orders.OrderId) SEPARATOR ", ") as "OrderIds"')
            ->join('orders', 'orders.CustomerId', '=', 'customers.CustomerId')
            ->groupBy('orders.CustomerId')
            ->orderBy($sort, $order);

        if ($request->get('appid') != null) {
            $searchQuery->where('ApplicationId', $request->get('appid'));
        }

        if ($request->get('query') != null) {
            $searchQuery->where(function ($query) use ($request) {
                $query->where('customers.CustomerName', 'like', "%" . $request->get('query', "") . "%")
                    ->orWhere('orders.OrderId', 'like', "%" . $request->get('query', "") . "%");
            });
        }

        if ($request->get('start') != null && $request->get('end') != null) {
            $searchQuery->whereBetween('orders.PurchaseDate', [$request->get('start'), $request->get('end')]);
        }

        return view('sales.order', [
            'customers' => $searchQuery->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE')),
            'sort' => $sort,
            'order' => $order,
        ]);
    }

    public function show(Request $request)
    {
        if (!$request->get('customerid')) {
            return abort(404);
        }

        $customer = Customer::with(['order' => function ($query) {
            $query->orderBy('PurchaseDate', 'desc');
        }, 'order.device'])->find($request->get('customerid'));

        return view('sales.order_show', [
            'customer' => $customer
        ]);

    }

    public function edit($orderId, Request $request)
    {
        return view('sales.order_edit', [
            'order' => Order::with('customer')->find($orderId)
        ]);
    }

    public function update($orderId, Request $request)
    {
        $request->validate([
            'ExpiredDate' => 'required',
            'Status' => 'required|numeric'
        ]);

        Order::where('OrderId', $orderId)
            ->update($request->only('ExpiredDate', 'Status'));
        return back();
    }

    public function destroy($orderId)
    {
        if (Order::destroy($orderId)) {
            return response(null);
        } else {
            return response("Xóa order $orderId thất bại", 500);
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
