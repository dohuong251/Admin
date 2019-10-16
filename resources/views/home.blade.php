@extends('layouts.main')
@section('title', 'Trang chủ')
@section('script')
    <script src="/js/vendors/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/vi.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/lodash.min.js"></script>
    <script src="/js/dashboard/index.js"></script>
@endsection
@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css"/>
@endsection

@section('content')
    <div class="container-fluid" style="zoom: 100%">
        <div id="lsp-chart">
            <input type="text" id="lsp-date-picker" class="form-control w-auto text-center mx-auto mt-3"
                   data-url="{{route('admin.lsp.stream_dashboard')}}">

            <div id="lsp-chart"></div>
        </div>
    </div>
@endsection
