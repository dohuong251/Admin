@extends('layouts.main')
@section('title', 'User')
@section('css')
    <link rel="stylesheet" type="text/css" href="/css/admin/user.css">
@endsection
@section('script')
    <script src="/js/admin/user.js"></script>
    <script src="/js/admin/confirm_submit_delete.js"></script>
@endsection
@section('content')

    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.livestreamplayer.users')}}">Management User</a>
            </li>

            <li class="breadcrumb-item active">
                <div>{{$user -> Nickname}}</div>
            </li>

            <li class="breadcrumb-menu" style="position: absolute; right: 0; margin-right: 20px">
                <form action="{{route('admin.livestreamplayer.user.delete', $user->UserId)}}" method="post" onsubmit="return confirmDelete(this)">
                    @method('DELETE')
                    {{csrf_field()}}
                    <button type="submit">Delete</button>
                </form>
            </li>
        </ol>

    </nav>

    <div class="container-fluid">
        @if (count($errors) > 0)
            <div class="alert alert-danger">

                    <span>
                        @foreach($errors->all() as $error)
                            <strong>{{ $error }}</strong>
                        @endforeach
                    </span>
            </div>
        @endif
        @if($user)
            <div class="profile">
                <div class="card mx-auto mb-3">
                    <div class="row no-gutters">
                        @if($user -> Avatar)
                            <div class="col-3 text-center">
                                <img src="{{$user->Avatar}}" class="img-fluid {{$user ->Avatar ? '': 'h-100'}}"
                                     style="background-size: cover; width: 100%">
                            </div>
                        @else
                            <div class="col-3">
                                <img src="/images/icon/avatar.png" class="img-fluid"
                                     style="background: #d2d6da; background-size: cover; width: 100%">
                            </div>
                        @endif
                        <div class="col-9">
                            <form id="editForm" class="card-body" action="{{route('admin.livestreamplayer.user', $user ->UserId)}}" method="post">
                                @method('PUT')
                                {{csrf_field()}}
                                <div class="float-right actionBtn">
                                    <button type="button" class="btn-secondary-custom editProfile">
                                        <i class="fa fa-edit" style="font-size: 14px !important;"></i>
                                    </button>
                                </div>
                                <div>
                                    <h5 class="card-title" title="Username" style="padding-left: 15px">
                                        <span>{{$user->Nickname}}</span>
                                    </h5>
                                    <div class="edtName ml-15 d-none">
                                        <input id="usename" class="form-control w-auto d-inline" type="text" name="nickname"
                                               placeholder="User name" title="User Name" value="{{$user->Nickname}}">
                                        <input id="password" class="form-control w-auto d-inline" type="password"
                                               placeholder="New password" title="Password" name="password">

                                        <select id="role" class="form-control w-auto d-inline-block" name="role">
                                            <?php $role = $user->Role;?>
                                            <option value="0" {{$role=="0"?"selected":""}}>Admin</option>
                                            <option value="1" {{$role=="1"?"selected":""}}>User</option>
                                        </select>

                                        <button type="button" title="Delete" class="btn-danger-custom float-right ml-1 btn-delete">
                                            <span><i class="fa fa-times"></i></span>
                                        </button>
                                        <button type="submit" title="Edit" class="btn-success-custom float-right btn-edit">
                                            <span><i class="fa fa-check"></i></span>
                                        </button>


                                    </div>
                                </div>


                                <div class="d-flex">
                                    <div class="flex-fill">
                                        <div>
                                            <p class="card-text">
                                            <span class="align-middle">
                                                <i class="ti ti-email"></i>
                                            </span>
                                                <label class="form-control border-0 d-inline">Email</label>
                                            </p>
                                            <div>
                                                <div class="d-flex" title="Email">
                                                    <span class="title form-control border-0 email ml-4">{{$user -> Email ?? 'Chưa có'}}</span>

                                                    <div class="edt-email d-none">
                                                        @if($user ->Type == 1)
                                                            <input type="email" class="form-control w-auto d-inline-block" name="email" value="{{$user->Email}}">
                                                        @else
                                                            <input type="text" title="Email" name="email"
                                                                   class="form-control w-auto d-inline-block"
                                                                   value="{{$user->Email}}" disabled>
{{--                                                            <span class="form-control border-0" style="margin-left: 25px" title="Email">{{$user -> Email}}</span>--}}
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <p class="card-text">
                                            <span class="align-middle">
                                                <i class="ti ti-email"></i>
                                            </span>
                                                <label class="form-control border-0 d-inline">FacebookId</label>
                                            </p>
                                            <div>
                                                <div class="d-flex" title="FacebookId">
                                                    <span class="title form-control border-0 facebook ml-4">{{$user -> FacebookId ?? 'Chưa có'}}</span>

                                                    <div class="d-none edt-fb">
                                                        @if($user -> Type== 0)
                                                            <input type="text" title="FacebookId"
                                                                   class="form-control w-auto d-inline-block" name="facebookId" value="{{$user->FacebookId}}">
                                                        @else
                                                            <input type="text" title="FacebookId" name="facebookId"
                                                                   class="form-control w-auto d-inline-block"
                                                                   value="{{$user->FacebookId}}" disabled>
{{--                                                                                                                <span class="form-control border-0" style="margin-left: 25px">{{$user->FacebookId}}</span>--}}
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="mt-3 role">
                                            <p class="card-text">
                                            <span class="align-middle">
                                                <i class="ti ti-email"></i>
                                            </span>
                                                <label class="form-control border-0 d-inline">Role</label>
                                            </p>
                                            <p class="d-flex" title="Role" style="margin-left: 25px">
                                                @switch($user -> Role)
                                                    @case (0)
                                                    <span class="title form-control border-0">Admin</span>
                                                    @break
                                                    @case (1)
                                                    <span class="title form-control border-0">User</span>
                                                    @break
                                                    @default <span class="title form-control border-0">User</span>
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex-fill">
                                        <div>
                                            <p class="card-text">
                                            <span class="align-middle">
                                                <i class="ti ti-email"></i>
                                            </span>
                                                <label class="form-control border-0 d-inline">Phone</label>
                                            </p>
                                            <div class="d-flex" title="Phone">
                                                <span class="title form-control border-0 ml-4 phone">{{$user ->Phone ?? 'Chưa có'}}</span>
                                                <div class="edt-phone d-none">
                                                    <input type="text" class="form-control w-auto d-inline-block"
                                                           value="{{$user -> Phone}}" name="phone">
                                                </div>

                                            </div>


                                        </div>

                                        <div class="mt-3">
                                            <p class="card-text">
                                            <span class="align-middle">
                                                <i class="ti ti-email"></i>
                                            </span>
                                                <label class="form-control border-0 d-inline">Birthday</label>
                                            </p>
                                            <div class="d-flex" title="Birthday">
                                                <span class="title form-control border-0 birthday ml-4">{{$user ->Birthday ?? 'Chưa có'}}</span>
                                                <div class="edt-birthday d-none">
                                                    <input type="date" class="form-control w-auto d-inline" value="{{$user -> Birthday}}" name="birthday">
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>

            <div class="list">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" class="align-middle" id="selectAll">
                        </th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Code</th>
                        <th scope="col" class="cell-inline">Channel Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Views</th>
                    </tr>
                    </thead>
                <tbody>
                @foreach($song as $song)
                <tr>
                    <th scope="row">
                        <input type="checkbox" class="selectRow">
                    <td>
                        <img src="{{$song->ImageURL}}" width="70" height="40" alt="">
                    </td>
                    <td>
                        <div>{{$song->Code}}</div>
                    </td>
                    <td>
                        <div>{{$song->Name}}</div>
                    </td>
                    <td>
                        <div>{{$song->RateCount}}</div>
                    </td>
                    <td>
                        <div>{{$song->ViewByAll}}</div>
                    </td>
                    </th>
                </tr>
                    @endforeach

                </tbody>

                </table>
{{--                {{$song->links('vendor.pagination.default')}}--}}
            </div>


        @endif
    </div>
@endsection
