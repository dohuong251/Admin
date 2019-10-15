@extends('layouts.main')
@section('title', 'User')
@section('css')
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
    <link rel="stylesheet" href="/css/vendors/datatables.min.css"/>
    <link rel="stylesheet" href="/css/vendors/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/lsp/user.css">
@endsection
@section('script')
    <script src="/js/vendors/datatables.min.js"></script>
    <script src="/js/vendors/datatable_plugins/input.js"></script>
    <script src="/js/lsp/user.js"></script>
    <script src="/js/lsp/confirm_submit_delete.js"></script>
@endsection
@section('content')

    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.lsp.users')}}">Management User</a>
            </li>

            <li class="breadcrumb-item active">
                <div>{{$user -> Nickname}}</div>
            </li>

            <li class="breadcrumb-menu ml-auto mr-2">
                <form action="{{route('admin.lsp.user', $user->UserId)}}" method="post"
                      onsubmit="return confirmDelete(this)">
                    @method('DELETE')
                    {{csrf_field()}}
                    <button class="btn btn-danger" type="submit">Delete</button>
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
                        <div class="col-sm-3 bg-secondary">
                            <img src="{{$user->Avatar??'/images/icon/avatar.png'}}" class="image-fit" alt="avatar">
                        </div>
                        <div class="d-flex overflow-hidden col-sm-9 col-12 py-2">
                            <div class="col-12 toggle-display-des information animated slideInLeft fast">
                                <div class="float-right actionBtn mr-2">
                                    <button type="button" class="btn-secondary-custom toggle-display">
                                        <i class="fa fa-edit" style="font-size: 14px !important;"></i>
                                    </button>
                                </div>
                                <div>
                                    <h5 class="card-title" title="{{$user->Nickname}}" style="padding-left: 15px">
                                        <span>{{$user->Nickname}}</span>
                                    </h5>
                                </div>
                                <div class="d-flex information-form">
                                    <div class="col-12 col-sm-6">
                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">email</i>
                                                <span class="align-middle">Email
                                            </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user -> Email ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                                {{$user -> Email ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="ti ti-facebook align-middle"></i>
                                                <span class="align-middle">
                                                    FacebookId
                                                </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user -> FacebookId ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                                {{$user -> FacebookId ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">people</i>
                                                <span class="align-middle">
                                                    Full name
                                                </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user -> Fullname ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                                {{$user->Fullname ? strlen($user->Fullname)>0?$user->Fullname:Config::get('constant.ATTRIBUTE_NULL') : Config::get('constant.ATTRIBUTE_NULL')}}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">phone</i>
                                                <span class="align-middle">
                                                    Số Điện thoại
                                                </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user -> Phone ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                                {{$user->Phone ? strlen($user->Phone)>0?$user->Phone:Config::get('constant.ATTRIBUTE_NULL') :Config::get('constant.ATTRIBUTE_NULL')}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 ">
                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">cake</i>
                                                <span class="align-middle">
                                                    Birthday
                                            </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user -> Birthday ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                                {{$user -> Birthday ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">report</i>
                                                <span class="align-middle">
                                                    Status
                                                </span>
                                            </div>
                                            {{--                                            <div class="pl-sm-4"--}}
                                            <div class="pl-sm-4"
                                                 title="{{$user -> Status ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                                {{$user -> Status ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">people_alt</i>
                                                <span class="align-middle">
                                                    Type
                                                </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user->Type==0?'Email':'Facebook'}}">
                                                {{$user->Type==0?'Email':'Facebook'}}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">person</i>
                                                <span class="align-middle">
                                                    Role
                                                </span>
                                            </div>
                                            <div class="pl-sm-4"
                                                 title="{{$user->Role==0?'Admin':'User'}}">
                                                {{$user->Role==0?'Admin':'User'}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- edit form --}}

                            <form
                                class="col-12 w-0 toggle-display-des information animated slideInRight fastmain position-relative"
                                action="{{route('admin.lsp.user', $user ->UserId)}}"
                                method="post">
                                @method('PUT')
                                {{csrf_field()}}
                                <div class="col-12 clearfix">
                                    <button type="button" class="float-right btn-danger-custom toggle-display">
                                        <i class="fa fa-times" style="font-size: 14px !important;"></i>
                                    </button>
                                    <button type="submit" class="float-right btn-success-custom mr-1">
                                        <i class="fa fa-check" style="font-size: 14px !important;"></i>
                                    </button>

                                    <label for="nickname">Nick Name:&nbsp;</label>
                                    <input id="nickname" class="card-title form-control w-auto d-inline"
                                           style="padding-left: 15px" type="text"
                                           value="{{$user->Nickname}}" name="Nickname" placeholder="Nhập nickname">
                                </div>
                                <div class="d-flex information-form">
                                    <div class="col-12 col-sm-6">
                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">email</i>
                                                <label for="email" class="align-middle">
                                                    Email:
                                                </label>
                                            </div>
                                            <input id="email" name="Email" value="{{$user -> Email}}"
                                                   class="form-control w-auto" placeholder="Nhập email">
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="ti ti-facebook align-middle"></i>
                                                <label for="facebookid" class="align-middle">
                                                    FacebookId:
                                                </label>
                                            </div>
                                            <input id="facebookid" value="{{$user -> FacebookId}}"
                                                   class="form-control w-auto" disabled>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">people</i>
                                                <label for="fullname" class="align-middle">
                                                    Full name:
                                                </label>
                                            </div>
                                            <input id="fullname" value="{{$user -> Fullname}}"
                                                   class="form-control w-auto" name="Fullname"
                                                   placeholder="Nhập Fullname">
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">phone</i>
                                                <label for="phone" class="align-middle">
                                                    Số Điện thoại:
                                                </label>
                                            </div>
                                            <input id="phone" value="{{$user -> Phone}}"
                                                   class="form-control w-auto" name="Phone"
                                                   placeholder="Nhập Số Điện Thoại">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 ">
                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">cake</i>
                                                <label for="birthday" class="align-middle">
                                                    Birthday:
                                                </label>
                                            </div>
                                            <input id="birthday" value="{{$user -> Birthday}}"
                                                   class="form-control w-auto" name="Birthday"
                                                   placeholder="Nhập Ngày Sinh">
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">report</i>
                                                <label for="status" class="align-middle">
                                                    Status:
                                                </label>
                                            </div>
                                            <select id="status" class="form-control w-auto" name="Status">
                                                <option value="0" {{$user -> Status==0?'selected':''}}>0</option>
                                                <option value="1" {{$user -> Status==1?'selected':''}}>1</option>
                                            </select>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">people_alt</i>
                                                <label for="type" class="align-middle">
                                                    Type:
                                                </label>
                                            </div>
                                            <select id="type" class="form-control w-auto" name="Type">
                                                <option value="0" {{$user -> Type==0?'selected':''}}>Email</option>
                                                <option value="1" {{$user -> Type==1?'selected':''}}>Facebook</option>
                                            </select>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">person</i>
                                                <label for="role" class="align-middle">
                                                    Role:
                                                </label>
                                            </div>
                                            <select id="role" class="form-control w-auto" name="Role">
                                                <option value="0" {{$user -> Role==0?'selected':''}}>Admin</option>
                                                <option value="1" {{$user -> Role==1?'selected':''}}>User</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

            <div class="list">
                <table class="w-100 table table-hover table-responsive-sm w-100" id="song-table" data-table-source="{{route('admin.lsp.user_streams',$user->UserId)}}">
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
                </table>
            </div>


        @endif
    </div>
@endsection
