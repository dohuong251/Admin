@extends('layouts.main')
@section('title', 'Apps')
@section('css')
    <link rel="stylesheet" href="/css/dist/dashboard.css">
@endsection
@section('js')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="/js/dist/apexcharts.min.js"></script>
    <script src="/js/app/index.js"></script>
    <script src="/js/app/overview.js"></script>
    <script>
        var filter_days = @json($filter_days);
        var new_user_count = @json($new_user_count);
        var active_count = @json($active_count);
        var countries_percent = @json($countries_percent);
        var countries_name = @json($countries_name);
        var start_date = '{{$start_date}}';
        var end_date = '{{$end_date}}';
    </script>

@endsection

@section('content')
    <form method="get" action="#">
        <div class="d-flex flex-row align-items-center" style="height: 60px;">
            <h3 style="margin-bottom: 0px; margin-left: 20px;">
                Overview
            </h3>

            <select class="form-control align-items-center" name="app_id" style="width: 200px; margin-left: 20px;">
                <option value="com.ustv.v2" {{$app_id=='com.ustv.v2'?'selected':''}}>USTV</option>
                <option value="com.liveplayer.v2" {{$app_id=='com.liveplayer.v2'?'selected':''}}>Live Stream Player</option>
            </select>

            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-left: 20px;">
                <i class="fa fa-calendar"></i>
                <span></span> <i class="fa fa-caret-down"></i>
            </div>

            <input type="hidden" name="start_date" class="e-start-date">
            <input type="hidden" name="end_date" class="e-end-date">

            <select name="selected_version" class="form-control" style="width: 200px; margin-left: 20px;">
                <option value="0" {{$selected_version=="0"?'selected':''}}>All Versions</option>
                @foreach($versions as $version)
                    <option value="{{$version}}" {{$selected_version==$version?'selected':''}}>Version {{$version}}</option>
                @endforeach

            </select>

            <button class="btn btn-outline-primary" style="margin-left: 20px;">Apply</button>

        </div>
    </form>


    <div class="container-fluid">
        <div class="row middle-home">
            <div class="col-md-6 card-container pr-2">
                <div class="card w-100 h-100">
                    <div class="card-header bg-white">
                        <div class="header-home-title">Daily Active User</div>
                        <div class="header-home-subtitle">{{$active_count[0]}} Active User</div>
                    </div>
                    <div id="daily_active_user_chart"></div>
                </div>
            </div>
            <div class="col-md-6 card-container pl-2">
                <div class="card w-100 h-100">
                    <div class="card-header bg-white">
                        <div class="header-home-title">Monthly New User</div>
                        <div class="header-home-subtitle">{{$new_user_count[0]}} New User</div>
                    </div>
                    <div id="daily_new_user_chart"></div>
                </div>
            </div>
        </div>

        <div class="row middle-home mt-3 mb-3">
            <div class="col-md-6 card-container pr-2">
                <div class="card w-100 h-100">
                    <div class="card-header bg-white">
                        <div class="header-home-title">Top Country</div>
                        <div class="header-home-subtitle">{{count($countries_name)>0?$countries_name[0]:'--'}} - {{count($countries_percent)>0?$countries_percent[0]:'0'}}%</div>
                    </div>
                    <div id="top_country_chart"></div>
                </div>
            </div>
        </div>

    </div>
@endsection
