@extends('layouts.main')
@section('title', 'Statistics')
@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css"/>
    <link rel="stylesheet" href="/css/vendors/select2.min.css">
    <style>
        .select2-selection, .select2-selection__arrow {
            height: 100% !important;
            border: 0 !important;
        }

        .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px) !important;
        }
    </style>
@endsection
@section('js')
    @verbatim
        <script id="stream-rank-template" type="text/x-handlebars-template">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Success Views</th>
                    <th scope="col">Playback Duration</th>
                    <th scope="col">Buffer Duration</th>
                </tr>
                </thead>
                <tbody>
                {{#topStreams}}
                <tr title="ChannelId: {{id}}">
                    <th scope="row">{{increase @index}}</th>
                    <td>{{id}}</td>
                    <td>{{symbol}}</td>
                    <td>{{number_format successViews}}</td>
                    <td>{{number_format_duration PlaybackDuration}}</td>
                    <td>{{number_format_duration BufferDuration}}</td>
                </tr>
                {{/topStreams}}
                </tbody>
            </table>
        </script>
    @endverbatim
    <script>
        let ajaxUrl = "{!! route('admin.ustv.dashboard.filter') !!}",
            ajaxSearchUrl = "{!! route('admin.ustv.dashboard.search') !!}";
    </script>
    <script src="/js/dist/ajax_setup_loading.js"></script>

    <script src="/js/vendors/apexcharts.min.js"></script>
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/select2.min.js"></script>
    <script src="/js/vendors/handlebars.min.js"></script>
    <script src="/js/ustv/dashboard.js?$$REVISION$$"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Ustv
            </li>
            <li class="breadcrumb-item justify-content-center">
                Dashboard
            </li>
        </ol>
    </nav>

    <div>
        <div class="peers">
            <div class="peer peer-greed">
                <div class="input-group rounded search-group border">
                    <input class="form-control border-left-0 border-top-0 border-bottom-0 border-right col-6" id="date-picker">
                    <div class="col-6 px-0">
                        <select class="custom-select w-auto rounded-0" id="streamSearch">
                            @if(isset($channel) && $channel)
                                <option value="{{$channel->id??""}}">{{$channel->id?$channel->id." - ":""}}{{$channel->Name??""}}</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="peer ml-2">
                <button class="btn btn-success" onclick="loadData()">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <div class="layer w-100 mT-15">
            <h5 class="mB-5" id="successViewCount"></h5>
            <small class="fw-600 c-grey-700">Success Views</small>
            <span class="pull-right c-grey-600 fsz-sm" id="successViewRatio"></span>
            <div class="progress mT-10">
                <div class="progress-bar bgc-green-500" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    {{--                    <span class="sr-only">80% Complete</span>--}}
                </div>
            </div>
        </div>

        <div class="stream-chart"></div>

        <div id="rank">
            <div id="stream-rank"></div>
        </div>
    </div>
@endsection
