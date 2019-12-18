@extends('layouts.main')
@section('title', 'Orders')
@section('css')

@endsection

@section('js')

    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/sale/order_show.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{route('admin.sales.order')}}">Order</a>
            </li>
            @if($customer)
                <li class="breadcrumb-item active" aria-current="page">
                    {{$customer->CustomerName}}
                </li>
            @endif
        </ul>
    </nav>
    @if(isset($customer))
        <div class="list table-responsive-sm ovX-a">
            <table class="table table-hover" id="content">
                <thead>
                <tr>
                    <th scope="col">OrderId</th>
                    <th scope="col">Application</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Expired Date</th>
                    <th scope="col">Purchase Method</th>
                    <th scope="col">Purchase Info</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customer->order as $order)
                    <tr>
                        <td>{{$order->OrderId}}</td>
                        <td>{{$order->ApplicationId}}</td>
                        <td>{{$order->PurchaseDate}}</td>
                        <td>{{$order->ExpiredDate}}</td>
                        <td>
                            <a href="javascript:void(0)" title="IMEI: {{$order->device->pluck('IMEI')->join(', ')}}">@switch($order->PurchaseMethod)
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
                                @endswitch</a>
                        </td>
                        <td>{{$order->PurchaseInfo}}</td>
                        <td>{{$order->Status==0?"Normal":"Locked"}}</td>
                        <td>
                            <a href="{{route('admin.sales.order.edit', $order->OrderId)}}">
                                <i class="fa fa-external-link-square"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="deleteOrder(this,'{{route('admin.sales.order.destroy', $order->OrderId)}}', {{$order->OrderId}})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    @endif

@endsection
