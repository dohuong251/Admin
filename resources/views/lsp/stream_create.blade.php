@extends('layouts.main')
@section('title', 'New Stream')
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
                Create Stream
            </li>
        </ol>

    </nav>

    <div class="profile">
        <div class="card mx-auto mb-3">
            <div class="row no-gutters">
                <div class="col-sm-3  bg-secondary">
                    {{--                            <img src="{{$user->Avatar??'/images/icon/avatar.png'}}" class="w-100 img-fluid rounded-circle centerXY-sm pos-a-sm" alt="avatar">--}}
                    <img src="/images/icon/tv.png" class="image-fit" alt="avatar">
                </div>
                <div class="d-flex overflow-hidden col-sm-9 col-12 py-2">
                    {{-- edit form --}}

                    <form
                        class="col-12 w-0 toggle-display-des information animated slideInRight fastmain position-relative"
                        action="{{route('admin.lsp.streams.store')}}"
                        method="post">
                        {{csrf_field()}}
                        <div class="col-12 clearfix card-title">
                            <button type="submit" class="float-right btn btn-success mr-1">
                                <i class="fa fa-check" style="font-size: 14px !important;"></i>
                            </button>

                            <label for="nickname">Name:&nbsp;</label>
                            <input id="nickname" class="form-control w-auto d-inline"
                                   style="padding-left: 15px" type="text"
                                   value="{{old('Name')}}" name="Name" placeholder="Nhập tên kênh" required>
                            <div class="text-danger">{{ $errors->first('Name') }}</div>
                        </div>
                        <div class="d-flex information-form">
                            <div class="col-12 col-sm-6">
                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">category</i>
                                        <label for="categoryId" class="align-middle">
                                            Thể Loại:
                                        </label>
                                    </div>
                                    <select id="categoryId" name="CategoryId" class="form-control w-auto">
                                        @foreach(\App\Models\Lsp\Categories::all() as $category)
                                            <option value="{{$category->CategoryId}}" {{$category->CategoryId==old('CategoryId')?'selected':''}}>{{$category->CategoryName}}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">{{ $errors->first('CategoryId') }}</div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">public</i>
                                        <label for="orivacy" class="align-middle">
                                            Privacy
                                        </label>
                                    </div>
                                    <select id="privacy" class="form-control w-auto" name="Privacy">
                                        <option value="0" {{old('Privacy')==0?'selected':''}}>Public</option>
                                        <option value="1" {{old('Privacy')==1?'selected':''}}>Private</option>
                                    </select>
                                    <div class="text-danger">{{ $errors->first('Privacy') }}</div>
                                </div>
                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">copyright</i>
                                        <label for="language" class="align-middle">
                                            Copyright
                                        </label>
                                    </div>
                                    <?php  $language = old('Language', "English") ?>
                                    <select id="language" class="form-control w-auto" name="Language">
                                        @include('layouts.language_select')
                                    </select>
                                    <div class="text-danger">{{ $errors->first('Language') }}</div>

                                </div>
                            </div>

                            <div class="col-12 col-sm-6 ">


                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">description</i>
                                        <label for="description" class="align-middle">
                                            Mô tả:
                                        </label>
                                    </div>
                                    <textarea id="description" class="form-control" name="Description">{{old('Description')}}</textarea>
                                    <div class="text-danger">{{ $errors->first('Description') }}</div>
                                </div>

                                <div>
                                    <div class="card-text">
                                        <i class="material-icons align-middle">link</i>
                                        <label for="url" class="align-middle">
                                            URL:
                                        </label>
                                    </div>
                                    <textarea id="url" class="form-control" name="URL" required>{{old('URL')}}</textarea>
                                    <div class="text-danger">{{ $errors->first('URL') }}</div>
                                </div>

                            </div>

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
@endsection
