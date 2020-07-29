@extends('layouts.main')
@section('title', 'Apps')
@section('css')
    <link rel="stylesheet" href="/css/dist/dashboard.css">
@endsection
@section('js')
    <script src="/js/dist/apexcharts.min.js"></script>
    <script src="/js/app/index.js"></script>
    <script src="/js/app/overview/index.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Overview
            </li>

            <li class="ml-auto">
                <select name="app_id">
                    <option value="com.ustv.v2">USTV</option>
                    <option value="com.liveplayer.v2">Live Stream Player</option>
                </select>
            </li>
        </ol>

    </nav>

    <div class="container-fluid">
        <div class="row middle-home">
            <div class="col-md-6 card-container pr-2">
                <div class="card w-100 h-100">
                    <div class="card-header bg-white">
                        <div class="header-home-title">Daily Active User</div>
                    </div>
                    <div id="review_article_chart"></div>
                </div>
            </div>
            <div class="col-md-6 card-container pl-2">
                <div class="card w-100 h-100">
                    <div class="card-header bg-white">
                        <div class="header-home-title">Daily New User</div>
                    </div>
                    <div id="visit_chart"></div>
                </div>
            </div>
        </div>

    </div>
@endsection
