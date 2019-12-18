@extends('layouts.main')
@section('title', 'Edit Order')
@section('css')
@endsection

@section('js')
    <script src="/js/sale/order_edit.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{route('admin.sales.order')}}">Order</a>
            </li>
            @if($order && $order->customer)
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{route('admin.sales.order.show',['customerid'=>$order->customer->CustomerId??0])}}">{{$order->customer->CustomerName??""}}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ul>
    </nav>
    @if(isset($order))
        <form action="{{route('admin.sales.order.update', $order->OrderId)}}" method="post">
            @method('PUT')
            @csrf
            <div class="d-flex flex-wrap">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="orderid">OrderId:</label>
                        <input class="form-control" id="orderid" value="{{$order->OrderId}}" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="appid">Application:</label>
                        <input class="form-control" id="appid" value="{{$order->ApplicationId}}" disabled/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="expire">Expired Date:</label>
                        <input class="form-control {{$errors->has('ExpiredDate')?'is-invalid':''}}" id="expire" name="ExpiredDate" value="{{old('ExpiredDate',$order->ExpiredDate)}}" required/>
                        @if($errors->has('ExpiredDate'))
                            <div class="text-danger">{{$errors->first('ExpiredDate')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="purchase-date">Purchase Date:</label>
                        <input class="form-control" id="purchase-date" value="{{$order->PurchaseDate}}" disabled/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="purchase-method">Purchase Method:</label>
                        <input class="form-control" id="purchase-method" value="@switch($order->PurchaseMethod)
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
                        @endswitch" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="purchase-info">Purchase Info:</label>
                        <input class="form-control" id="purchase-info" value="{{$order->PurchaseInfo}}" disabled/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="Status">
                            <option value="0" {{old('Status',$order->Status)==0?"selected":""}}>Normal</option>
                            <option value="1" {{old('Status',$order->Status)==1?"selected":""}}>Locked</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="purchase-cipherkey">CipherKey:</label>
                        <textarea class="form-control" id="purchase-cipherkey" disabled>{{$order->CipherKey}}</textarea>
                    </div>
                </div>
            </div>
            <div class="text-center mb-3">
                <button class="btn btn-success m-a">Save</button>
            </div>
        </form>
    @endif

@endsection
