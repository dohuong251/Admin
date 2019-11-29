@extends('layouts.main')
@section('title', 'User')
@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css"/>
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
@endsection
@section('js')
    <script src="/js/vendors/spin.min.js"></script>
    <script src="/js/vendors/ladda.min.js"></script>
    <script src="/js/vendors/sweetalert2.all.min.js"></script>
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/vendors/jquery.dataTables.min.js"></script>
    <script src="/js/lsp/user.js"></script>
    <script src="/js/dist/delete.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.lsp.user.index')}}">Management User</a>
            </li>

            @if($user)
                <li class="breadcrumb-item active">
                    {{$user -> Nickname}}
                </li>

                <li class="breadcrumb-menu ml-auto mr-2 d-flex c-white">
                    <a class="btn btn-primary mr-2" href="{{route('admin.lsp.messages.index',['userid'=>$user->UserId])}}">
                        <i class="fa fa-fw fa-commenting-o"></i>
                    </a>
                    <form action="{{route('admin.lsp.user.destroy', $user->UserId)}}" method="post"
                          onsubmit="return confirmDelete(this)">
                        @method('DELETE')
                        {{csrf_field()}}
                        <button class="btn btn-danger" type="submit">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </form>
                </li>
            @endif
        </ol>

    </nav>

    <div>
        @if($user)
            <div class="profile">
                <div class="card mx-auto mb-3">
                    <div class="row no-gutters">
                        <div class="col-sm-3">
                            {{--                            <img src="{{$user->Avatar??'/images/icon/avatar.png'}}" class="w-100 img-fluid rounded-circle centerXY-sm pos-a-sm" alt="avatar">--}}
                            <img src="{{$user->Avatar}}" class="user-avatar image-fit" alt="avatar" onerror="onLoadAvatarError(this)">
                        </div>
                        <div class="d-flex overflow-hidden col-sm-9 col-12 py-2 {{count($errors)>0?'justify-content-end':''}}">

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
                                class="col-12 w-0 toggle-display-des information animated slideInRight fast position-relative"
                                action="{{route('admin.lsp.user.update', $user ->UserId)}}"
                                method="post">
                                @method('PUT')
                                {{csrf_field()}}
                                <div class="col-12 card-title clearfix">
                                    <button type="button" class="float-right btn-danger-custom toggle-display">
                                        <i class="fa fa-times" style="font-size: 14px !important;"></i>
                                    </button>
                                    <button type="submit" class="float-right btn-success-custom mr-1">
                                        <i class="fa fa-check" style="font-size: 14px !important;"></i>
                                    </button>

                                    <label for="nickname">Nick Name:&nbsp;</label>
                                    <input id="nickname" class="form-control w-auto d-inline" type="text"
                                           value="{{old('Nickname',$user->Nickname)}}" name="Nickname" placeholder="Nhập nickname">
                                    <div class="text-danger">{{ $errors->first('Nickname') }}</div>
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
                                            <input type="email" id="email" name="Email" value="{{old('Email',$user->Email)}}"
                                                   class="form-control w-auto" placeholder="Nhập email">
                                            <div class="text-danger">{{ $errors->first('Email') }}</div>
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
                                            <input id="fullname" value="{{old('Fullname',$user->Fullname)}}"
                                                   class="form-control w-auto" name="Fullname"
                                                   placeholder="Nhập Fullname">
                                            <div class="text-danger">{{ $errors->first('Fullname') }}</div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">phone</i>
                                                <label for="phone" class="align-middle">
                                                    Số Điện thoại:
                                                </label>
                                            </div>
                                            <input id="phone" value="{{old('Phone',$user->Phone)}}"
                                                   class="form-control w-auto" name="Phone"
                                                   placeholder="Nhập Số Điện Thoại">
                                            <div class="text-danger">{{ $errors->first('Phone') }}</div>
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
                                            <input id="birthday" value="{{old('Birthday',$user->Birthday)}}"
                                                   class="form-control w-auto" name="Birthday"
                                                   placeholder="Nhập Ngày Sinh">
                                            <div class="text-danger">{{ $errors->first('Birthday') }}</div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">report</i>
                                                <label for="status" class="align-middle">
                                                    Status:
                                                </label>
                                            </div>
                                            <select id="status" class="form-control w-auto" name="Status">
                                                <option value="0" {{old('Status', $user->Status)==0?'selected':''}}>0</option>
                                                <option value="1" {{old('Status', $user->Status)==1?'selected':''}}>1</option>
                                            </select>
                                            <div class="text-danger">{{ $errors->first('Status') }}</div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">people_alt</i>
                                                <label for="type" class="align-middle">
                                                    Type:
                                                </label>
                                            </div>
                                            <select id="type" class="form-control w-auto" name="Type">
                                                <option value="0" {{old('Type', $user->Type)==0?'selected':''}}>Email</option>
                                                <option value="1" {{old('Type', $user->Type)==1?'selected':''}}>Facebook</option>
                                            </select>
                                            <div class="text-danger">{{ $errors->first('Type') }}</div>
                                        </div>

                                        <div>
                                            <div class="card-text">
                                                <i class="material-icons align-middle">person</i>
                                                <label for="role" class="align-middle">
                                                    Role:
                                                </label>
                                            </div>
                                            <select id="role" class="form-control w-auto" name="Role">
                                                <option value="0" {{old('Role', $user->Role)==0?'selected':''}}>Admin</option>
                                                <option value="1" {{old('Role', $user->Role)==1?'selected':''}}>User</option>
                                            </select>
                                            <div class="text-danger">{{ $errors->first('Role') }}</div>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

            <div class="list table-responsive-sm">
                <table class="w-100 table table-hover w-100" id="song-table" data-table-source="{{route('admin.lsp.user.streams',$user->UserId)}}">
                    <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" class="align-middle" id="selectAll">
                        </th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Code</th>
                        <th scope="col" class="text-nowrap">Channel Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Views</th>
                    </tr>
                    </thead>
                </table>
            </div>
        @else
            <div class="mb-2">
                <b>Thành viên không tồn tại</b>
            </div>
        @endif
    </div>
    @include('layouts.deleteButton')
@endsection
