@extends('layouts.main')
@section('title', 'Apps')
@section('css')

@endsection
@section('js')
    <script src="/js/app/index.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Apps
            </li>

            <li class="ml-auto">
                <a href="{{route('admin.apps.create')}}" class="btn-success-custom">
                    <i class="fa fa-plus align-bottom"></i>
                    <span>Add new app</span>
                </a>
            </li>
        </ol>

    </nav>
    <div class="peers">
        @if($apps)
            @foreach($apps as $app)
                <div class="col-4 col-md-2 mB-15 mT-15">
                    <a href="{{route('admin.apps.show',$app->app_id)}}" class="w-100 border shadow-sm position-relative pt-100p cur-p app-card d-block" title="{{$app->app_version_name??$app->app_name??""}}">
                        <div class="t-0 l-0 r-0 b-0 position-absolute text-center d-flex flex-column">
                            <div class="flex-grow-1 d-flex align-items-center">
                                <div class="w-100">
                                    <img src="{{$app->icon_url??""}}" class="mw-50 mh-50 of-cv"/>
                                </div>
                            </div>
                            <div class="b-0 text-center w-100 px-2 py-2 ellipsis"><b>{{$app->app_version_name??$app->app_name??""}}</b></div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection
