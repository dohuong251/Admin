@extends('layouts.main')
@section('title', 'Realtime')
@section('css')

@endsection
@section('js')
    @verbatim
        <script id="stream-list-template" type="text/x-handlebars-template">
            <div class="row jc-fe mx-0">
                <span class="badge badge-primary mx-2 mb-2 cur-p td-u-hover sort" data-sort="PLAYING">Playing{{order_type "PLAYING" sort}}</span>
                <span class="badge badge-warning mx-2 mb-2 cur-p td-u-hover sort" data-sort="BUFFERING">Buffering{{order_type "BUFFERING" sort}}</span>
                <span class="badge badge-danger mx-2 mb-2 cur-p td-u-hover sort" data-sort="CONNECTING">Connecting{{order_type "CONNECTING" sort}}</span>
            </div>
            <ul class="list-group">
                {{#each channels}}
                <li class="list-group-item">
                    <div class="peers">
                        <div class="peer peer-greed">{{Code}} -
                            @endverbatim
                            <a target="_blank" href="{{route('admin.lsp.analytic.statistics')}}?streamId=@{{StreamId}}">
                                @verbatim
                                    <b>{{Name}}</b>
                            </a>
                        </div>
                        <div class="peer col-12 col-sm-auto">
                            <span class="badge badge-pill badge-success">{{number_format PLAYING}}</span>
                            <span class="badge badge-pill badge-warning">{{number_format BUFFERING}}</span>
                            <span class="badge badge-pill badge-danger">{{number_format CONNECTING}}</span>
                            <span class="badge badge-pill badge-success">LivePlayer iOS {{calculatePercent IOS PLAYING BUFFERING CONNECTING}}%</span>
                            <span class="badge badge-pill badge-success">LSP Android {{calculatePercent Android PLAYING BUFFERING CONNECTING}}%</span>
                        </div>
                    </div>
                </li>
                {{/each}}
            </ul>
        </script>
    @endverbatim
    <script>
        var filterUrl = "{!! route('admin.lsp.analytic.realtime.filter') !!}";
    </script>
    <script src="/js/vendors/apexcharts.min.js"></script>
    <script src="/js/vendors/handlebars.min.js"></script>
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/lsp/analytic_realtime.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Realtime
            </li>

            <li class="breadcrumb-menu ml-auto mr-2 d-flex">
                {{--                <button class="btn btn-danger mr-2" type="submit" title="suspend" data-toggle="modal" data-target="#exampleModal">--}}
                {{--                    <i class="fa fa-ban"></i>--}}
                {{--                </button>--}}
            </li>
        </ol>

    </nav>

    <div id="active-user-chart" data-href="{{route('admin.lsp.analytic.realtime.active_user')}}">

    </div>

    <div class="gap-20">
        <div class="row gap-20">
            <div class="col-12 col-sm-3 realtime-card" id="channel-card">
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10"><h6 class="lh-1">Channels</h6></div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <div class="realtime-chart"></div>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500 primary-value"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-3 realtime-card" id="view-card">
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10"><h6 class="lh-1">Views</h6></div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <div class="realtime-chart"></div>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500 primary-value"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-3 realtime-card" id="ios-card">
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10"><h6 class="lh-1">iOS</h6></div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <div class="realtime-chart"></div>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500 primary-value"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-3 realtime-card" id="android-card">
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10"><h6 class="lh-1">Android</h6></div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                                <div class="realtime-chart"></div>
                            </div>
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500 primary-value"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mT-10" id="stream-list">

    </div>
@endsection
