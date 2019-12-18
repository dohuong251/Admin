@extends('layouts.main')
@section('title', 'Subscriptions')
@section('css')
@endsection

@section('js')
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/vendors/sweetalert2.all.min.js"></script>
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/sale/subscription.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">Subscription</li>
            <li class="breadcrumb-menu ml-auto mr-2">
                <form action="{{route('admin.sales.subscription')}}" method="get">
                    <div class="input-group">
                        <select name="searchType" class="form-control">
                            <option value="Email" {{Request()->get('searchType')=="Email"?"selected":""}}>Email</option>
                            <option value="FacebookID" {{Request()->get('searchType')=="FacebookID"?"selected":""}}>Facebook Id</option>
                            <option value="DeviceID" {{Request()->get('searchType')=="DeviceID"?"selected":""}}>Device Id</option>
                            <option value="PayPalSubscriberID" {{Request()->get('searchType')=="PayPalSubscriberID"?"selected":""}}>Paypal SubscriberId</option>
                            <option value="PayPalEmail" {{Request()->get('searchType')=="PayPalEmail"?"selected":""}}>Paypal Email</option>
                            <option value="OrderId" {{Request()->get('searchType')=="OrderId"?"selected":""}}>Order Id</option>
                        </select>
                        <input name="query" aria-label="Search..." placeholder="Search..." class="form-control" value="{{Request()->get('query')}}"/>
                    </div>
                </form>
            </li>
        </ul>
    </nav>
    @if(isset($subscriptions))
        <div class="list table-responsive-sm ovX-a">
            <table class="table table-hover" id="content">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Email</th>
                    <th scope="col">Type</th>
                    <th scope="col">PaymentMethod</th>
                    @if(isset($sort) && $sort == "TransactionDate")
                        @if(strtolower($order) == "asc")
                            <th class="sorting_asc">
                                <a class=""
                                   href="{{route('admin.sales.subscription',array_merge(Request()->all(),['sort'=>'TransactionDate','order'=>'asc','page'=>1]))}}">
                                    TransactionDate
                                </a>
                            </th>
                        @else
                            <th class="sorting_desc">
                                <a class=""
                                   href="{{route('admin.sales.subscription',array_merge(Request()->all(),['sort'=>'TransactionDate','order'=>'desc','page'=>1]))}}">
                                    TransactionDate
                                </a>
                            </th>
                        @endif
                    @else
                        <th class="sorting">
                            <a class=""
                               href="{{route('admin.sales.subscription',array_merge(Request()->all(),['sort'=>'TransactionDate','order'=>'desc','page'=>1]))}}">
                                TransactionDate
                            </a>
                        </th>
                    @endif
                    <th scope="col">Duration</th>
                    <th scope="col">IsTrial</th>
                    <th scope="col">PaypalSubscriberId</th>
                    <th scope="col">PaypalEmail</th>
                    <th scope="col">OrderId</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td class="cur-p toggle-child-row">
                            <i class="fa fa-plus-circle text-success"></i>
                        </td>
                        <td>{{$subscription->Email}}</td>
                        <td>@switch($subscription->AccountType)
                                @case(0) Email @break
                                @case(1) Facebook @break
                                @case(2) Device @break
                                @case(3) Apple @break
                            @endswitch</td>
                        <td>@switch($subscription->PaymentMethod)
                                @case(0) Key
                                @break
                                @case(1) Paymall
                                @break
                                @case(2) Phone Card
                                @break
                                @case(3) Amazon
                                @break
                                @case(4) Apple
                                @break
                                @case(5) Paypal
                                @break
                                @case(6) License Key
                                @break
                                @case(7) MDC Admin
                                @break
                            @endswitch</td>
                        <td class="text-nowrap">{{$subscription->TransactionDate}}</td>
                        <td>{{$subscription->Duration==0?"Forever":$subscription->Duration." months"}}</td>
                        <td>{{$subscription->IsTrial==0?"False":"True"}}</td>
                        <td class="text-nowrap">{{$subscription->PayPalSubscriberID}}</td>
                        <td>{{$subscription->PayPalEmail}}</td>
                        <td>{{$subscription->OrderId}}</td>
                        <td>
                            <a href="{{route('admin.sales.subscription.edit',$subscription->SubscriptionID)}}">
                                <i class="fa fa-external-link-square"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="deleteSubscription(this,'{{route('admin.sales.subscription.destroy', $subscription->SubscriptionID)}}', {{$subscription->SubscriptionID}})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="child-row d-none">
                        <td colspan="11">
                            <ul style="list-style: none">
                                <li><b>Facebook Id:</b> {{$subscription->FacebookID}}</li>
                                <li><b>Device Id:</b> {{$subscription->DeviceID}}</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        {{$subscriptions->links('vendor.pagination.custom')}}
    @endif

@endsection
