@extends('layouts.main')
@section('title', 'Users')
@section('script')
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/lsp/ajax_setup.js"></script>
    <script src="/js/lsp/users.js"></script>
    <script src="/js/lsp/delete.js"></script>
    <script src="/js/vendors/datatables.min.js"></script>
    <script src="/js/vendors/datatable_plugins/input.js"></script>
    @include('layouts.script.sweetalert')
    @include('layouts.script.ladda')
@endsection
@section('css')
    {{--    thư viện animation css--}}
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
    <link rel="stylesheet" href="/css/lsp/users.css" type="text/css"/>
    <link rel="stylesheet" href="/css/vendors/datatables.min.css"/>
    <link rel="stylesheet" href="/css/vendors/jquery.dataTables.min.css"/>
@endsection
@section('content')
    {{--    <ul class="nav-left w-100 pr-3"> class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);">--}}
    {{--            <i--}}
    {{--                class="search-icon ti-search pdd-right-10"></i>--}}
    {{--            <i--}}
    {{--                class="search-icon-close ti-close pdd-right-10"></i>--}}
    {{--        </a>--}}
    {{--            <form action="{{route('admin.lsp.user')}}" method="get">--}}
    {{--                <input name="query" class="form-control" type="text" placeholder="Search...">--}}
    {{--                <input type="submit" hidden>--}}
    {{--                <input name="type" value="0" hidden>--}}
    {{--            </form>--}}
    {{--    </ul>--}}

    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">User Management</li>
        </ul>
    </nav>
    <div class="container-fluid">
        @if(isset($users))
            <input class="form-control mb-2 w-auto ml-md-auto" type="text" placeholder="Search" aria-label="Search"/>
            <div class="list table-responsive-md ovX-a" id="list">
                <table class="table table-hover" id="content">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            <input type="checkbox" class="align-middle" id="selectAll">
                        </th>
                        <th scope="col">Nickname</th>
                        <th scope="col">Email | FacebookId</th>
                        <th>
                            @if(isset($sort) && $sort == "Views")
                                @if(strtolower($order) == "desc")
                                    <a class="nav-link active"
                                       href="{{route('admin.lsp.users',['sort'=>'Views','order'=>'asc'])}}">
                                        Σ Views of Streams<span><i class="ti-angle-down"></i></span>
                                    </a>
                                @else
                                    <a class="nav-link active"
                                       href="{{route('admin.lsp.users',['sort'=>'Views','order'=>'desc'])}}">
                                        Σ Views of Streams
                                        <span><i class="ti-angle-up"></i></span>
                                    </a>
                                @endif
                            @else
                                <a class="nav-link active"
                                   href="{{route('admin.lsp.users',['sort'=>'Views','order'=>'desc'])}}">
                                    Σ Views of Streams
                                </a>
                            @endif
                        </th>

                        <th>@if(isset($sort) && $sort == "Streams")
                                @if(strtolower($order) == "desc")
                                    <a class="nav-link active"
                                       href="{{route('admin.lsp.users',['sort'=>'Streams','order'=>'asc'])}}">
                                        Σ Streams<span><i class="ti-angle-down"></i></span>
                                    </a>
                                @else
                                    <a class="nav-link active"
                                       href="{{route('admin.lsp.users',['sort'=>'Streams','order'=>'desc'])}}">
                                        Σ Streams
                                        <span><i class="ti-angle-up"></i></span>
                                    </a>
                                @endif
                            @else
                                <a class="nav-link active"
                                   href="{{route('admin.lsp.users',['sort'=>'Streams','order'=>'desc'])}}">
                                    Σ Streams
                                </a>
                            @endif</th>
                        <th>Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr data-href={{route('admin.lsp.user',$user->UserId)}}>
                            <th scope="row" class="align-middle">
                                <input type="checkbox" class="selectRow" data-id="{{$user -> UserId}}">
                            </th>
                            <td>
                                {{$user -> Nickname}}
                            </td>
                            <td>
                                {{$user -> Email ?? $user -> FacebookId}}
                            </td>
                            <td>
                                {{number_format($user->Views)}}
                            </td>
                            <td>
                                {{number_format($user->Streams)}}
                            </td>
                            <td>
                                {{$user->Role == 0 ? "Admin" : "User"}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{$users->links('vendor.pagination.custom')}}
            </div>
            @include('layouts.deleteButton')
        @else
            <strong>Không tìm thấy thành viên</strong>
        @endif
    </div>

@endsection
