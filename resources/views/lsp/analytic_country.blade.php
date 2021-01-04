@extends('layouts.main')
@section('title', 'Country')
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
                    <th scope="col">Code</th>
                    <th scope="col">Stream Name</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Success Views</th>
                    <th scope="col">Country</th>
                </tr>
                </thead>
                <tbody>
                {{#topStreams}}
                <tr title="{{CountryDes}}" {{#if (reach_limit @index)}}class="d-none slide-up"{{/if}}>
                    <th scope="row">{{increase @index}}</th>
                    {{#if StreamUrl}}
                    <td>
                        <a href="{{StreamUrl}}" target="_blank">{{Code}}</a>
                    </td>
                    {{else}}
                    <td>{{Code}}</td>
                    {{/if}}

                    <td>{{Name}}</td>

                    {{#if OwnerUrl}}
                    <td>
                        <a href="{{OwnerUrl}}" target="_blank">{{Owner}}</a>
                    </td>
                    {{else}}
                    <td>{{Owner}}</td>
                    {{/if}}
                    <td>{{number_format successViews}}</td>
                    <td><pre>{{CountryDes}}</pre></td>
                </tr>
                {{/topStreams}}
                </tbody>
            </table>
        </script>
        <script id="user-rank-template" type="text/x-handlebars-template">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nickname</th>
                    <th scope="col">SuccessViews</th>
                    <th scope="col">Streams</th>
                    <th scope="col">Country Views</th>
                </tr>
                </thead>
                <tbody>
                {{#topUsers}}
                <tr title="{{CountryDes}}">
                    <th scope="row">{{increase @index}}</th>
                    <td>{{Nickname}}</td>
                    <td>{{number_format successViews}}</td>
                    <td>{{number_format Streams}}</td>
                    <td><pre>{{CountryDesShort}}</pre></td>
                </tr>
                {{/topUsers}}
                </tbody>
            </table>
        </script>
    @endverbatim
    <script>
        let ajaxUrl = "{!! route('admin.lsp.analytic.country.filter') !!}",
            ajaxSearchUrl = "{!! route('admin.lsp.analytic.country.search') !!}";
    </script>
    <script src="/js/dist/ajax_setup_loading.js"></script>

    <script src="/js/vendors/apexcharts.min.js"></script>
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/select2.min.js"></script>
    <script src="/js/vendors/handlebars.min.js"></script>
    <script src="/js/lsp/country.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Analytic
            </li>
            <li class="breadcrumb-item justify-content-center">
                Country
            </li>
        </ol>
    </nav>

    <div>
        <div class="peers">
            <div class="peer peer-greed">
                <div class="input-group rounded search-group border">
                    <input class="form-control border-left-0 border-top-0 border-bottom-0 border-right col-4" id="date-picker">
                    <div class="col-4 px-0 border-right">
                        <select class="custom-select w-auto rounded-0" id="userSearch">
                            @if(isset($stream) && $stream==null)
                                <option value="{{$stream->users->UserId??""}}">{{$stream->users->Nickname??""}}</option>
                            @else
                                <option value="9545">Seder Maza</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-4 px-0">
                        <select class="custom-select w-auto rounded-0" id="streamSearch">
                            @if(isset($stream) && $stream)
                                <option value="{{$stream->SongId??""}}">{{$stream->Name??""}}</option>
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

        <div class="stream-chart"></div>

        <div id="rank">
            <div id="user-rank"></div>
            <div id="stream-rank"></div>
        </div>
    </div>
@endsection
