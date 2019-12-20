@extends('layouts.main')
@section('title', 'Channels')
@section('css')
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
@endsection
@section('js')
    <script src="/js/vendors/spin.min.js"></script>
    <script src="/js/vendors/ladda.min.js"></script>
    <script src="/js/vendors/sweetalert2.all.min.js"></script>
    <script src="/js/dist/delete.js"></script>
    <script src="/js/ustv/channels.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Ustv
            </li>
            <li class="breadcrumb-item justify-content-center">
                Channels
            </li>
        </ol>
    </nav>

    <div>
        <form class="text-right" action="{{route('admin.ustv.channels')}}" method="get">
            <div class="ml-auto px-0 input-group d-inline-flex w-auto">
                <select name="id_type_tv" class="custom-select">
                    <option value="9" {{Request()->get('id_type_tv')=="9"?"selected":""}}>US</option>
                    <option value="20" {{Request()->get('id_type_tv')=="20"?"selected":""}}>UK</option>
                    <option value="12" {{Request()->get('id_type_tv')=="12"?"selected":""}}>International</option>
                </select>
                <select name="filter" class="custom-select" id="streamSearch">
                    <option value="id" {{Request()->get('filter')=="id"?"selected":""}}>Channel Id</option>
                    <option value="symbol" {{Request()->get('filter')=="symbol"?"selected":""}}>Channel Name</option>
                    <option value="description" {{Request()->get('filter')=="description"?"selected":""}}>Channel Description</option>
                    <option value="url" {{Request()->get('filter')=="url"?"selected":""}}>URL</option>
                </select>
                <input class="form-control" placeholder="Search Channels ..." name="query" value="{{Request()->get('query')}}"/>
                <div class="input-group-append">
                    <button class="btn btn-success">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        @if(!empty($channels))
            <div class="list table-responsive-sm ovX-a">
                <table class="table table-hover" id="content">
                    <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="selectAll" class="align-middle">
                        </th>
                        @if(isset($sort) && $sort == "id")
                            @if(strtolower($order) == "asc")
                                <th class="sorting_asc">
                                    <a class=""
                                       href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'id','order'=>'desc']))}}">
                                        Id
                                    </a>
                                </th>
                            @else
                                <th class="sorting_desc">
                                    <a class=""
                                       href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'id','order'=>'asc']))}}">
                                        Id
                                    </a>
                                </th>
                            @endif
                        @else
                            <th class="sorting">
                                <a class=""
                                   href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'id','order'=>'desc']))}}">
                                    Id
                                </a>
                            </th>
                        @endif
                        @if(isset($sort) && $sort == "symbol")
                            @if(strtolower($order) == "asc")
                                <th class="sorting_asc">
                                    <a class=""
                                       href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'symbol','order'=>'desc']))}}">
                                        Name
                                    </a>
                                </th>
                            @else
                                <th class="sorting_desc">
                                    <a class=""
                                       href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'symbol','order'=>'asc']))}}">
                                        Name
                                    </a>
                                </th>
                            @endif
                        @else
                            <th class="sorting">
                                <a class=""
                                   href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'symbol','order'=>'desc']))}}">
                                    Name
                                </a>
                            </th>
                        @endif
                        <th scope="col">Description</th>
                        <th scope="col">URL</th>
                        <th scope="col">Thumbnail</th>
                        @if(isset($sort) && $sort == "watch_counter")
                            @if(strtolower($order) == "asc")
                                <th class="sorting_asc">
                                    <a class=""
                                       href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'watch_counter','order'=>'desc']))}}">
                                        Total View
                                    </a>
                                </th>
                            @else
                                <th class="sorting_desc">
                                    <a class=""
                                       href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'watch_counter','order'=>'asc']))}}">
                                        Total View
                                    </a>
                                </th>
                            @endif
                        @else
                            <th class="sorting">
                                <a class=""
                                   href="{{route('admin.ustv.channels',array_merge(Request()->all(),['sort'=>'watch_counter','order'=>'desc']))}}">
                                    Total View
                                </a>
                            </th>
                        @endif
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($channels as $channel)
                        <tr>
                            <th scope="row" class="align-middle">
                                <input type="checkbox" class="align-middle select-row" data-id="{{$channel->id}}">
                            </th>
                            <td>{{$channel->id}}</td>
                            <td>{{$channel->symbol}}</td>
                            <td>
                                <span class="ellipsis-2-row">{{$channel->description}}</span>
                            </td>
                            <td>{{$channel->url->count()??0}}</td>
                            <td>
                                @if($channel->icon_name)
                                    <img data-src="{{$channel->icon_name}}" class="image-thumb image-fit img-thumbnail">
                                @endif
                            </td>
                            <td>{{number_format($channel->watch_counter)}}</td>
                            <td class="d-flex" style="letter-spacing: 5px">
                                <a class="text-info cur-p">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a class="text-secondary cur-p">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="text-danger cur-p">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
            {{$channels->links('vendor.pagination.custom')}}
        @else
            No Channels Found.
        @endif
    </div>
    @include('layouts.deleteButton')
@endsection
