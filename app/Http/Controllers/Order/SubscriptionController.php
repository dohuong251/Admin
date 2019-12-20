<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Sale\Subscription;
use Config;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'TransactionDate');
        $order = $request->get('order', 'desc');

        $searchQuery = Subscription::orderBy($sort, $order);
        if ($request->get("query") != null) {
            $searchQuery->where($request->get("searchType"), 'like', "%" . $request->get('query') . "%");
        }

        return view('sales.subscription', [
            'subscriptions' => $searchQuery->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'))->appends(Request()->except('page')),
            'sort' => $sort,
            'order' => $order,
        ]);
    }

    public function show()
    {

    }

    public function edit($subscriptionId)
    {
        $subscription = Subscription::find($subscriptionId);
        return view('sales.subscription_edit', [
            'subscription' => $subscription
        ]);
    }

    public function update($subscriptionId, Request $request)
    {
        $request->validate([
            "Email" => "required",
            "AccountType" => "required",
            "PaymentMethod" => "required",
            "TransactionDate" => "required",
            "ExpiresDate" => "required",
        ]);
//        dd($request->all());

        Subscription::where('SubscriptionId', $subscriptionId)
            ->update($request->only('Email', 'FacebookID', 'AccountType', 'PaymentMethod', 'TransactionDate', 'ExpiresDate', 'OrderId'));
        return back();
    }

    public function destroy($subscriptionId)
    {
        if (Subscription::destroy($subscriptionId)) {
            return response(null);
        } else return response("Xóa subscription $subscriptionId thất bại", 500);
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
