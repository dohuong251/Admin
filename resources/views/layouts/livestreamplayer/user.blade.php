@extends('layouts.main')
@section('title', 'Users')
@section('script')
    <script src="/js/admin/ajax_setup.js"></script>
    <script src="/js/admin/users.js"></script>
    <script src="/js/admin/delete.js"></script>
    @include('layouts.script.sweetalert')
    @include('layouts.script.ladda')

@endsection
@section('css')
    {{--    thư viện animation css--}}
        <link rel="stylesheet" href="/css/admin/animate.min.css">
        <link rel="stylesheet" href="/css/admin/ladda.min.css">
    <link rel="stylesheet" href="{{asset('/css/admin/users.css')}}" type="text/css">
@endsection
@section('content')
    {{--    <ul class="nav-left w-100 pr-3"> class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);">--}}
    {{--            <i--}}
    {{--                class="search-icon ti-search pdd-right-10"></i>--}}
    {{--            <i--}}
    {{--                class="search-icon-close ti-close pdd-right-10"></i>--}}
    {{--        </a>--}}
    {{--            <form action="{{route('admin.livestreamplayer.user')}}" method="get">--}}
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
        <div class="list">
            @if(isset($users))
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" class="align-middle" id="selectAll">
                        </th>
                        <th scope="col">Nickname</th>
                        <th scope="col">Email | FacebookId</th>
                        <th>
                            <a class="nav-link active" href="#">&sum; Views of Streams <span><i class="ti-angle-down"></i></span></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)

                        <tr>
                            <th scope="row" class="align-middle">
                                <input type="checkbox" class="selectRow" data-id="{{$user -> UserId}}">
                            </th>

                            <td>
                                <div>
                                    <a href="{{route('admin.livestreamplayer.user',$user->UserId)}}">{{$user -> Nickname}}</a>
                                </div>
                            </td>
                            <td>
                                @if($user -> Email == null)
                                    <div>{{$user -> FacebookId}}</div>
                                @else
                                    <div>{{$user -> Email}}</div>
                                @endif
                            </td>
                            <td>
                                <div>{{number_format($user -> Views)}}</div>
                            </td>

                        </tr>

                    @endforeach
                    </tbody>
                </table>

                {{$users->links('vendor.pagination.custom')}}

                @include('layouts.deleteButton')
            @else
                <strong>Không tìm thấy thành viên</strong>
            @endif
        </div>

    </div>

@endsection
