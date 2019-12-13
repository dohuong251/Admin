@extends('layouts.main')
@section('title', 'Users')
@section('js')

    <script src="/js/vendors/spin.min.js"></script>
    <script src="/js/vendors/ladda.min.js"></script>
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/lsp/users.js"></script>
    <script src="/js/dist/delete.js"></script>
@endsection
@section('css')
    {{--    thư viện animation css--}}
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
@endsection
@section('content')
    {{--    <ul class="nav-left w-100 pr-3"> class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);">--}}
    {{--            <i--}}
    {{--                class="search-icon ti-search pdd-right-10"></i>--}}
    {{--            <i--}}
    {{--                class="search-icon-close ti-close pdd-right-10"></i>--}}
    {{--        </a>--}}
    {{--            <form action="{{route('admin.lsp.user.index')}}" method="get">--}}
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
    @if(isset($users))
        {{--            <input class="form-control mb-2 w-auto ml-md-auto" type="text" placeholder="Search" aria-label="Search"/>--}}
        <div class="list table-responsive-md ovX-a" id="list">
            <table class="table table-hover" id="content">
                <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" class="align-middle" id="selectAll">
                    </th>
                    <th scope="col">Nickname</th>
                    <th scope="col">Email | FacebookId</th>
                    @if(isset($sort) && $sort == "Views")
                        @if(strtolower($order) == "desc")
                            <th class="sorting_asc">
                                <a class=""
                                   href="{{route('admin.lsp.user.index',['sort'=>'Views','order'=>'asc'])}}">
                                    Σ Views of Streams
                                </a>
                            </th>
                        @else
                            <th class="sorting_desc">
                                <a class=""
                                   href="{{route('admin.lsp.user.index',['sort'=>'Views','order'=>'desc'])}}">
                                    Σ Views of Streams
                                </a>
                            </th>
                        @endif
                    @else
                        <th class="sorting">
                            <a class=""
                               href="{{route('admin.lsp.user.index',['sort'=>'Views','order'=>'desc'])}}">
                                Σ Views of Streams
                            </a>
                        </th>
                    @endif

                    @if(isset($sort) && $sort == "Streams")
                        @if(strtolower($order) == "desc")
                            <th class="sorting_asc">
                                <a class=""
                                   href="{{route('admin.lsp.user.index',['sort'=>'Streams','order'=>'asc'])}}">
                                    Σ Streams &#9660;
                                </a>
                            </th>
                        @else
                            <th class="sorting_desc">
                                <a class=""
                                   href="{{route('admin.lsp.user.index',['sort'=>'Streams','order'=>'desc'])}}">
                                    Σ Streams &#9650;
                                </a>
                            </th>
                        @endif
                    @else
                        <th class="sorting">
                            <a class=""
                               href="{{route('admin.lsp.user.index',['sort'=>'Streams','order'=>'desc'])}}">
                                Σ Streams
                            </a>
                        </th>
                    @endif
                    <th>Type</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr data-href={{route('admin.lsp.user.show',$user->UserId)}}>
                        <th scope="row" class="align-middle">
                            <input type="checkbox" class="select-row" data-id="{{$user -> UserId}}">
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

        </div>
        {{--                    {{$users->links()}}--}}
        {{$users->links('vendor.pagination.custom')}}
        @include('layouts.deleteButton')
    @else
        <strong>Không tìm thấy thành viên</strong>
    @endif
@endsection
