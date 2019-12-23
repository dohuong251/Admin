@extends('layouts.main')
@section('title', 'Purchase Orders')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css"/>

@endsection

@section('js')
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/clipboard.min.js"></script>
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/sale/order.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">
{{--                <a href="{{route('admin.sales.order')}}">Order</a>--}}
                Order
            </li>
            <li class="breadcrumb-menu ml-auto mr-2">
                <form method="get" action="{{route('admin.sales.order')}}">
                    <div class="input-group">
                        <select class="custom-select" name="appid">
                            <option value="">Select App</option>
                            <option value="Live Media Player" {{Request()->get('appid')=="Live Media Player"? "selected" : ""}}>
                                Live Media Player
                            </option>
                            <option value="USTV" {{Request()->get('appid')=="USTV"? "selected" : ""}}>
                                USTV
                            </option>
                            <option value="UKTV" {{Request()->get('appid')=="UKTV"? "selected" : ""}}>
                                UKTV
                            </option>
                            <option value="mTorrent" {{Request()->get('appid')=="mTorrent"? "selected" : ""}}>
                                mTorrent
                            </option>
                            <option value="mPlayer" {{Request()->get('appid')=="mPlayer"? "selected" : ""}}>
                                mPlayer
                            </option>
                            <option value="Live Stream Player" {{Request()->get('appid')=="Live Stream Player"? "selected" : ""}}>
                                Live Stream Player
                            </option>
                            <option value="Live Stream Player AndroidTV" {{Request()->get('appid')=="Live Stream Player AndroidTV"? "selected" : ""}}>
                                LSP AndroidTV
                            </option>
                        </select>
                        <input type="text" aria-label="Date Ranger" class="form-control date-picker" value="{{Request()->get('start')&&Request()->get('end')?implode(" - ",array_filter([date("d/m/Y",strtotime(Request()->get('start'))), date("d/m/Y",strtotime(Request()->get('end')))])):null}}" placeholder="Choose Range">
                        <input type="hidden" name="start" value="{{Request()->get('start')}}">
                        <input type="hidden" name="end" value="{{Request()->get('end')}}">
                        <input type="text" aria-label="Search Query" class="form-control" name="query" value="{{Request()->get('query')}}" placeholder="Search Name or OrderId">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </nav>
    @if(isset($customers))
        <div class="list table-responsive-sm ovX-a">
            <table class="table table-hover" id="content">
                <thead>
                <tr>
                    <th scope="col">CustomerId</th>
                    <th scope="col">CustomerName</th>
                    <th scope="col">PurchasedApps</th>
                    @if(isset($sort) && $sort == "totalOrders")
                        @if(strtolower($order) == "asc")
                            <th class="sorting_asc">
                                <a class=""
                                   href="{{route('admin.sales.order',array_merge(Request()->all(),['sort'=>'totalOrders','order'=>'desc','page'=>1]))}}">
                                    TotalOrders
                                </a>
                            </th>
                        @else
                            <th class="sorting_desc">
                                <a class=""
                                   href="{{route('admin.sales.order',array_merge(Request()->all(),['sort'=>'totalOrders','order'=>'asc','page'=>1]))}}">
                                    TotalOrders
                                </a>
                            </th>
                        @endif
                    @else
                        <th class="sorting">
                            <a class=""
                               href="{{route('admin.sales.order',array_merge(Request()->all(),['sort'=>'totalOrders','order'=>'desc','page'=>1]))}}">
                                TotalOrders
                            </a>
                        </th>
                    @endif
                    {{--                    <th scope="col">Total Orders</th>--}}
                    @if(isset($sort) && $sort == "PurchaseDate")
                        @if(strtolower($order) == "asc")
                            <th class="sorting_asc">
                                <a class=""
                                   href="{{route('admin.sales.order',array_merge(Request()->all(),['sort'=>'PurchaseDate','order'=>'desc','page'=>1]))}}">
                                    LastPurchase
                                </a>
                            </th>
                        @else
                            <th class="sorting_desc">
                                <a class=""
                                   href="{{route('admin.sales.order',array_merge(Request()->all(),['sort'=>'PurchaseDate','order'=>'asc','page'=>1]))}}">
                                    LastPurchase
                                </a>
                            </th>
                        @endif
                    @else
                        <th class="sorting">
                            <a class=""
                               href="{{route('admin.sales.order',array_merge(Request()->all(),['sort'=>'PurchaseDate','order'=>'desc','page'=>1]))}}">
                                LastPurchase
                            </a>
                        </th>
                    @endif
                    {{--                    <th scope="col">Last Purchase</th>--}}
                    <th scope="col">OrderId</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{$customer->CustomerId}}</td>
                        <td>{{$customer->CustomerName}}</td>
                        <td>{{$customer->ApplicationPurchases}}</td>
                        <td>{{$customer->totalOrders}}</td>
                        <td>{{$customer->PurchaseDate}}</td>
                        <td title="{{$customer->OrderIds}}"><span class="ellipsis-2-row">{{$customer->OrderIds}}</span></td>
                        <td>
                            <a href="{{route('admin.sales.order.show',['customerid'=>$customer->CustomerId])}}">
                                <i class="fa fa-external-link-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        {{$customers->links('vendor.pagination.custom')}}
    @endif

@endsection
