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
    <script src="/js/dist/ajax_setup_loading.js"></script>

    <script src="/js/vendors/apexcharts.min.js"></script>
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/select2.min.js"></script>
    <script src="/js/lsp/statistics_connection.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Analytic
            </li>
            <li class="breadcrumb-item justify-content-center">
                Connections
            </li>
        </ol>
    </nav>

    <div class="my-3">
        <form class="peers filter-form" action="{{route("admin.lsp.analytic.connection.filter")}}" method="post">
            <div class="peer peer-greed">
                <div class="input-group rounded search-group border">
                    <input class="form-control border-left-0 border-top-0 border-bottom-0 border-right col-4" required placeholder="Chọn khoảng thời gian" name="date-range">
                    <input name="date-range-start" type="hidden">
                    <input name="date-range-end" type="hidden">
                    <div class="col-4 px-0 border-right">
                        <select class="custom-select w-auto rounded-0" name="id_application" id="id_application">
{{--                            <option disabled selected>Chọn Application</option>--}}
                            @foreach(\App\Models\Tool\Connection::select("id_application")->distinct("id_application")->get() as $application)
                                <option value="{{$application->id_application}}">{{$application->id_application}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 px-0">
                        <select class="custom-select w-auto rounded-0" name="Version" id="Version" data-url="{{route("admin.lsp.analytic.connection.search_version")}}">
{{--                            <option disabled selected>Chọn Version</option>--}}
                        </select>
                    </div>
                </div>
            </div>
            <div class="peer ml-2">
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>

        <div class="connection-daily-chart"></div>
        <div class="device-daily-chart"></div>
        <div class="pie-total-chart"></div>
    </div>
@endsection
