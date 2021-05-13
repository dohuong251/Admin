@extends('layouts.main')
@section('title', 'Apps')
@section('css')

@endsection

@section('js')

    <script src="/js/vendors/lodash.min.js"></script>
    <script src="/js/vendors/handlebars.min.js"></script>
    <script id="edit-modal-content" type="text/x-handlebars-template">
        @verbatim
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{data.0.app_version_name}} for {{data.0.platform.name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            {{#data}}
            <div class="my-3">
                <div class="btn-group app-version">
                    @endverbatim
                    <a class="btn btn-primary" style="width: 200px" href="{{route('admin.apps.edit_version')}}?version_id=@{{app_version_id}}">
                        @verbatim

                            Version {{version_name}}
                    </a>
                    <button class="btn btn-danger delete-version" data-href="/admin/apps/{{app_version_id}}" data-version-id="{{app_version_id}}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            {{/data}}
        </div>
        @endverbatim
    </script>
    <script>
        let apps = [];
        @if($apps)
            apps =@json($apps);
        @endif
    </script>
    <script src="/js/app/show.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.apps.index')}}">Apps</a>
            </li>

            <li class="ml-auto">
            </li>
        </ol>

    </nav>
    <div class="peers">
        @if($apps)
            @foreach($apps->unique('platform_id') as $app)
                {{--                <div class="col-4 col-md-2 mB-15 mT-15">--}}
                {{--                    <a href="#" data-platform="{{$app->platform_id}}" data-toggle="modal" data-target="#edit-modal" class="w-100 border shadow-sm position-relative pt-100p app-card d-block" title="{{$app->app_version_name??$app->app_name??""}}">--}}
                {{--                        <div class="t-0 l-0 r-0 b-0 position-absolute text-center d-flex flex-column">--}}
                {{--                            <div class="flex-grow-1 d-flex align-items-center">--}}
                {{--                                <div class="w-100">--}}
                {{--                                    <img src="{{$app->icon_url??""}}" class="mw-50 mh-50 of-cv"/>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="b-0 text-center w-100 px-2 py-2 ellipsis">--}}
                {{--                                <a class="cur-a" href="javascript:void(0)">--}}
                {{--                                    <b>{{$app->app_version_name??$app->app_name??""}}</b>--}}
                {{--                                    <small class="d-block">{{$app->platform->name}}</small>--}}
                {{--                                </a>--}}
                {{--                            </div>--}}
                {{--                            <a href="#" class="z-1">--}}
                {{--                                <i class="fa fa-plus" title="new version"></i>--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                <div class="col-4 col-md-2 mB-15 mT-15">
                    <div class="app-card shadow-sm">
                        <button class="btn btn-success border-success bdw-1 rounded-circle z-1 float-right position-relative fsz-def mT-nv-10 mR-nv-10" onclick="window.location='{{route('admin.apps.add_version',[Route::input('appId'),"platform"=>$app->platform_id])}}'" title="new version">
                            <i class="fa fa-plus"></i>
                        </button>
                        <a href="#" data-platform="{{$app->platform_id}}" data-toggle="modal" data-target="#edit-modal" class="w-100 border position-relative pt-100p cur-p d-block" title="{{$app->app_version_name??$app->app_name??""}}">
                            <div class="t-0 l-0 r-0 b-0 position-absolute text-center d-flex flex-column">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <div class="w-100">
                                        <img src="{{$app->icon_url??""}}" class="mw-50 mh-50 of-cv"/>
                                    </div>
                                </div>
                                <div class="b-0 text-center w-100 px-2 py-2 ellipsis">
                                    <b>{{$app->app_version_name??$app->app_name??""}}</b>
                                    <small class="d-block">{{$app->platform->name}}</small>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            @endforeach
        @else
            <div class="mb-2">
                <b>Không tìm thấy app</b>
            </div>
        @endif
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>
@endsection
