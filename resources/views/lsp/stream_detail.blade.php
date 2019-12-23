@extends('layouts.main')
@section('title', 'Stream Detail')
@section('css')
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
@endsection
@section('js')
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.lsp.streams.index')}}">Management Stream</a>
            </li>

            <li class="breadcrumb-item active">
                {{$song->Name}}
            </li>

            <li class="breadcrumb-menu ml-auto mr-2 d-flex">
                <button class="btn btn-danger mr-2" type="submit" title="suspend" data-toggle="modal" data-target="#suspendModal">
                    <i class="fa fa-ban"></i>
                </button>

                <form action="{{route('admin.lsp.streams.destroy',$song->SongId)}}" method="post"
                      onsubmit="return confirmDelete(this)">
                    @method('DELETE')
                    {{csrf_field()}}
                    <input name="SongId" value="{{$song->SongId}}" type="hidden"/>
                    <button class="btn btn-danger" type="submit" title="delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </li>
        </ol>

    </nav>

    <div class="profile">
        @if (session('status'))
            <div class="text-danger text-center">
                <b>{{ session('insertErr') }}</b>
            </div>
        @endif
        <div class="card mx-auto mb-3">
            <div class="row no-gutters">
                <div class="col-sm-3 {{$song->ImageURL?'':' bg-secondary'}}">
                    {{--                            <img src="{{$user->Avatar??'/images/icon/avatar.png'}}" class="w-100 img-fluid rounded-circle centerXY-sm pos-a-sm" alt="avatar">--}}
                    <img src="{{$song->ImageURL??'/images/icon/tv.png'}}" class="image-fit" alt="avatar">
                </div>
                <div class="d-flex overflow-hidden col-sm-9 col-12 py-2">
                    <div class="col-12 toggle-display-des information animated slideInLeft fast">
                        <div>
                            <h5 class="card-title" title="{{$song->Name}}" style="padding-left: 15px">
                                <span>{{$song->Name}}</span>
                            </h5>
                        </div>
                        <div class="d-flex information-form">
                            <div class="col-12 col-sm-6">
                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">person</i>
                                        <span class="align-middle">Owner</span>
                                    </div>
                                    <div class="pl-sm-4"
                                         title="{{$song -> users -> Nickname ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                        <a href="{{route('admin.lsp.user.show',$song->users->UserId??0)}}">
                                            {{$song -> users -> Nickname ?? ""}}
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">system_update</i>
                                        <span class="align-middle">
                                            Code
                                        </span>
                                    </div>
                                    <div class="pl-sm-4"
                                         title="{{$song -> Code ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                        {{$song -> Code ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                    </div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">category</i>
                                        <span class="align-middle">
                                            Thể Loại
                                        </span>
                                    </div>
                                    <div class="pl-sm-4"
                                         title="{{$song->category->CategoryName ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                        {{$song->category->CategoryName ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                    </div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">public</i>
                                        <span class="align-middle">
                                                    Privacy
                                                </span>
                                    </div>
                                    <div class="pl-sm-4"
                                         title="{{$song -> Privacy ? 'Private' : 'Public'}}">
                                        {{$song -> Privacy ? 'Private' : 'Public'}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 ">
                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">copyright</i>
                                        <span class="align-middle">
                                                    Copyright
                                            </span>
                                    </div>
                                    <div class="pl-sm-4"
                                         title="{{$song -> Copyright}}">
                                        {{$song -> Copyright}}
                                    </div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">description</i>
                                        <span class="align-middle">
                                            Mô tả
                                        </span>
                                    </div>
                                    <div class="pl-sm-4 ellipsis-2-row"
                                         title="{{$song -> Description ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                        {{$song -> Description ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                    </div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">link</i>
                                        <span class="align-middle">
                                            URL
                                        </span>
                                    </div>
                                    <div class="pl-sm-4 ellipsis-2-row"
                                         title="{{$song -> URL ?? Config::get('constant.ATTRIBUTE_NULL')}}">
                                        {{$song -> URL ?? Config::get('constant.ATTRIBUTE_NULL')}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="actionBtn ta-c mt-2">
                            <button type="button" class="btn btn-secondary toggle-display">
                                <i class="fa fa-edit" style="font-size: 14px !important;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- edit form --}}

                    <form
                        class="col-12 w-0 toggle-display-des information animated slideInRight fastmain position-relative"
                        action="{{route('admin.lsp.streams.show', $song ->SongId)}}"
                        method="post">
                        @method('PUT')
                        {{csrf_field()}}
                        <div class="col-12 clearfix">
                            <label for="nickname">Name:&nbsp;</label>
                            <input id="nickname" class="card-title form-control w-auto d-inline"
                                   style="padding-left: 15px" type="text"
                                   value="{{old('Name',$song->Name)}}" name="Name" placeholder="Nhập tên kênh">
                        </div>
                        <div class="d-flex information-form">
                            <div class="col-12 col-sm-6">
                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">person</i>
                                        <label for="owner" class="align-middle">
                                            Owner:
                                        </label>
                                    </div>
                                    <input id="owner" value="{{$song->users->Nickname??""}}"
                                           class="form-control w-auto" disabled>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">system_update</i>
                                        <label for="code" class="align-middle">
                                            Code:
                                        </label>
                                    </div>
                                    <input id="code" value="{{$song->Code}}"
                                           class="form-control w-auto" placeholder="Nhập email" disabled>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">category</i>
                                        <label for="categoryId" class="align-middle">
                                            Thể Loại:
                                        </label>
                                    </div>
                                    <select id="categoryId" name="CategoryId" class="custom-select w-auto">
                                        @foreach(\App\Models\Lsp\Categories::all() as $category)
                                            <option value="{{$category->CategoryId}}" {{$category->CategoryId==old('CategoryId',$song->CategoryId)?'selected':''}}>{{$category->CategoryName}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">public</i>
                                        <label for="privacy" class="align-middle">
                                            Privacy
                                        </label>
                                    </div>
                                    <select id="privacy" class="custom-select w-auto" name="Privacy">
                                        <option value="0" {{old('Privacy',$song->Privacy)==0?'selected':''}}>Public</option>
                                        <option value="1" {{old('Privacy',$song->Privacy)==1?'selected':''}}>Private</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-12 col-sm-6 ">
                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">copyright</i>
                                        <label for="copyright" class="align-middle">
                                            Copyright
                                        </label>
                                    </div>
                                    <select id="copyright" class="custom-select w-auto" name="Copyright">
                                        <option value="0" {{old('Copyright',$song->Copyright)==0?'selected':''}}>0</option>
                                        <option value="1" {{old('Copyright',$song->Copyright)==1?'selected':''}}>1</option>
                                    </select>

                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">description</i>
                                        <label for="description" class="align-middle">
                                            Mô tả:
                                        </label>
                                    </div>
                                    <textarea id="description" class="form-control" name="Description">{{old('Description',$song->Description)}}</textarea>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">link</i>
                                        <label for="url" class="align-middle">
                                            URL:
                                        </label>
                                    </div>
                                    <textarea id="url" class="form-control" name="URL">{{old('URL',$song->URL)}}</textarea>
                                </div>

                            </div>

                        </div>
                        <div class="mt-2 ta-c">
                            <button type="button" class="btn btn-danger toggle-display">
                                <i class="fa fa-times" style="font-size: 14px !important;"></i>
                            </button>
                            <button type="submit" class="btn btn-success mr-1">
                                <i class="fa fa-check" style="font-size: 14px !important;"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

    {{--    <div class="list table-responsive-sm">--}}
    {{--        <table class="w-100 table table-hover w-100" id="song-table" data-table-source="{{route('admin.lsp.stream_complain',$song->SongId)}}">--}}
    {{--            <thead>--}}
    {{--            <tr>--}}
    {{--                <th scope="col">--}}
    {{--                    <input type="checkbox" class="align-middle" id="selectAll">--}}
    {{--                </th>--}}
    {{--                <th scope="col">Reason</th>--}}
    {{--                <th scope="col">Reporter</th>--}}
    {{--                <th scope="col" class="text-nowrap">Time</th>--}}
    {{--                <th scope="col">Rate</th>--}}
    {{--                <th scope="col">Views</th>--}}
    {{--            </tr>--}}
    {{--            </thead>--}}
    {{--        </table>--}}
    {{--    </div>--}}
    @include('lsp.layout_modal_suspend_stream')
@endsection
