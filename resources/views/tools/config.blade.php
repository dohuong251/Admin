@extends('layouts.main')
@section('title', 'Config')
@section('css')
    <link rel="stylesheet" href="/css/dist/fontawesome5.css">
    <link rel="stylesheet" href="/css/vendors/select2.min.css"/>
    <style>
        .select2-selection.select2-selection--single, .select2-selection__arrow {
            height: 35px !important;
        }

        span.select2-selection__rendered {
            line-height: 35px !important;
        }
    </style>
@endsection
@section('js')
    {{--                {{#isJSONField name}}--}}
    {{--                <div>JSON FIELD--}}
    {{--                    {{> configItem name=name value=value}}--}}
    {{--                </div>--}}
    {{--                {{else}}--}}
    {{--                {{> configItem name=name value=value}}--}}
    {{--                {{/isJSONField}}--}}
    @verbatim
        <script id="config-content" type="text/x-handlebars-template">
            <button class="btn btn-success add-config">
                <i class="fa fa-plus"></i>
            </button>
            <div class="d-flex flex-wrap config-container">
                <input type="hidden" name="appid" value="{{id}}">
                <input type="hidden" name="device" value="{{device}}">
                {{#data}}
                {{> configItem name=name value=value}}
                {{/data}}
            </div>
            <button class="btn btn-success d-block mT-15 m-auto submit-config">
                <i class="fa fa-check"></i>
            </button>
        </script>
        <script id="config-item" type="text/text/x-handlebars-template">
            {{#isJSONField name}}
            <div class="config-group col-12 d-flex mT-15">
                {{else}}
                <div class="config-group col-12 col-md-6 d-flex mT-15">
                    {{/isJSONField}}
                    <div class="input-group">
                        <textarea class="form-control name noresize" type="text" rows="1">{{name}}</textarea>
                        <textarea class="form-control value resize-vertical" type="text" rows="1">{{value}}</textarea>
                    </div>
                    <div class="d-flex">
                        <i class="fa fa-times ml-2 cur-p remove-config cH-red-200" title="remove"></i>
                        <i class="fa5 fa5-brackets-curly cur-p ml-2 mark-json cH-blue-200" title="mark as json"></i>
                    </div>
                </div>
        </script>

        <script id="json-config-content" type="text/text/x-handlebars-template">
            <div class="col-12 json-config-group mT-15 pB-15 border border-success">
                <div class="peers mT-15">
                    <textarea class="form-control data-json-prefix noresize w-50" rows="1">{{prefix}}</textarea>
                    <button class="btn btn-success add-json-config ml-2">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                {{#each json}}
                {{> jsonConfigItem key=@key value=this}}
                {{/each}}
            </div>
        </script>
        <script id="json-config-item" type="text/text/x-handlebars-template">
            <div class="config-group w-100 d-flex mT-15">
                <div class="input-group">
                    <textarea class="form-control json-name noresize" type="text" rows="1">{{key}}</textarea>
                    <textarea class="form-control json-value resize-vertical" data-json-attribute="true" type="text" rows="1">{{value}}</textarea>
                </div>
                <div class="d-flex">
                    <i class="fa fa-times ml-2 cur-p remove-config cH-red-200"></i>
                    <i class="fa fa-eye ml-2 cur-p preview-html cH-green-200"></i>
                </div>
            </div>
        </script>
    @endverbatim
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/vendors/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsonlint/1.6.0/jsonlint.min.js"></script>

    <script src="/js/vendors/handlebars.min.js"></script>
    <script src="/js/tool/config.js"></script>
@endsection
@section('content')
    <nav class="mX-15">
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Tools
            </li>

            <li class="breadcrumb-item justify-content-center">
                Config
            </li>

            <li class="ml-auto">
                <button class="btn btn-success" id="add-app">
                    <i class="fa fa-plus align-bottom"></i>
                    <span>New app</span>
                </button>
                <button class="btn btn-success" id="add-app-duplicate">
                    <i class="fa fa-copy align-bottom"></i>
                    <span>New app current config</span>
                </button>
            </li>
        </ol>

    </nav>

    @if($configApps)
        <div>
            <div class="d-flex flex-wrap">
                <div class="col-12 col-sm-6 pr-sm-0">
                    <select class="custom-select" name="configSearch">
                        @foreach($configApps as $app)
                            <option value="{{$app->id_application}}">{{$app->id_application}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                    <select name="device" id="device" class="custom-select mb-2" onchange="loadConfig()">
                        <option value="0" selected>Google</option>
                        <option value="1">Amazon</option>
                        <option value="2">Samsung</option>
                        <option value="3">MDC</option>
                        <option value="4">AppleTV</option>
                    </select>
                </div>
            </div>

            <div class="peer col-12 mt-2">
                <form onsubmit="return false;">
                    <input class="form-control d-none" value="" id="config-name-input" placeholder="new application id" required/>
                    <input type="submit" hidden/>
                </form>
            </div>

            <div class="config-content p-20"></div>
        </div>

    @endif
@endsection
