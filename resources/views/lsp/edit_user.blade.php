<form id="editForm" class="card-body" action="{{route('admin.lsp.user', $user ->UserId)}}" method="post">
    @method('PUT')
    {{csrf_field()}}
    <div class="edtName ml-15 d-none">
        <input id="usename" class="form-control w-auto d-inline" type="text" name="nickname"
               placeholder="User name" title="User Name" value="{{$user->Nickname}}">
        <input id="password" class="form-control w-auto d-inline" type="password"
               placeholder="New password" title="Password">

        <select id="role" class="form-control w-auto d-inline-block" name="role">
            <?php $role = $user->Type;?>
            <option value="0" {{$role=="1"?"selected":""}}>User</option>
            <option value="1" {{$role=="0"?"selected":""}}>Admin</option>
        </select>

        <button type="button" title="Delete" class="btn-danger-custom float-right ml-1 btn-delete">
            <span><i class="fa fa-times"></i></span>
        </button>
        <button type="submit" title="Edit" class="btn-success-custom float-right btn-edit">
            <span><i class="fa fa-check"></i></span>
        </button>
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
{{--                        <span class="title form-control border-0 email ml-4">{{$user -> Email ?? 'Chưa có'}}</span>--}}

                        <div class="edt-email">
                            @if($user ->Email == null)
                                <input type="email" class="form-control w-auto d-inline-block" name="email">
                            @else
                                <input type="text" title="Email"
                                       class="form-control w-auto d-inline-block"
                                       value="{{$user->Email}}" disabled>
                                {{--                                                    <span class="form-control border-0" style="margin-left: 25px" title="Email">{{$user -> Email}}</span>--}}
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
{{--                        <span class="title form-control border-0 facebook ml-4">{{$user -> FacebookId ?? 'Chưa có'}}</span>--}}

                        <div class="edt-fb">
                            @if($user -> FacebookId == null)
                                <input type="text" title="FacebookId"
                                       class="form-control w-auto d-inline-block" name="facebookId">
                            @else
                                <input type="text" title="FacebookId"
                                       class="form-control w-auto d-inline-block"
                                       value="{{$user->FacebookId}}" disabled="">
                                {{--                                                    <span class="form-control border-0" style="margin-left: 25px">{{$user->FacebookId}}</span>--}}
                            @endif
                        </div>
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
{{--                            <span class="title form-control border-0 ml-4 phone">{{$user ->Phone ?? 'Chưa có'}}</span>--}}
                            <div class="edt-phone">
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
{{--                            <span class="title form-control border-0 birthday ml-4">{{$user ->Birthday ?? 'Chưa có'}}</span>--}}
                            <div class="edt-birthday">
                                <input type="date" class="form-control w-auto d-inline" value="{{$user -> Birthday}}" name="birthday">
                            </div>

                        </div>

                    </div>

                </div>

            </div>

</form>
