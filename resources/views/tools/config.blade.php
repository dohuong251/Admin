@extends('layouts.main')
@section('title', 'Config')
@section('css')
    <link rel="stylesheet" href="/css/dist/fontawesome5.css">
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
        <div class="peers flex-nowrap">
            <div class="peer bdR" id="chat-sidebar">
                <div class="layers h-100">
                    <div class="bdB layer w-100">
                        <input type="text" placeholder="Search config" name="configSearch" class="form-constrol p-15 bdrs-0 w-100 bdw-0">
                        <select name="device" id="device" class="custom-select mb-2" onchange="loadConfig()">
                            <option value="0" selected>Google</option>
                            <option value="1">Amazon</option>
                            <option value="2">Samsung</option>
                            <option value="3">MDC</option>
                            <option value="4">AppleTV</option>
                        </select>
                    </div>
                    <div class="layer w-100 fxg-1 scrollable pos-r">
                        @foreach($configApps as $app)
                            @if($app)
                                <div class="peers fxw-nw ai-c p-20 bgc-white bgcH-grey-50 cur-p config-name">
                                    <span>{{$app->id_application??""}}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="peer peer-greed">
                <div class="layers h-100 message-content">
                    <div class="layer w-100 shadow-sm">
                        <div class="peers fxw-nw jc-sb ai-c pY-20 pX-30 bgc-white">
                            <div class="peers ai-c">
                                <div class="peer d-n@md+">
                                    <a href="" title="" class="td-n c-grey-900 cH-blue-500 mR-30 chat-sidebar-toggle">
                                        <i class="ti-menu"></i>
                                    </a>
                                </div>

                                <div class="peer">
                                    <h6 class="lh-1 mB-0" id="config-name"></h6>
                                    <form onsubmit="return false;">
                                        <input class="form-control d-none" value="" id="config-name-input" placeholder="new application id" required/>
                                        <input type="submit" hidden/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layer w-100 fxg-1 scrollable pos-r ps">
                        <div class="config-content p-20"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
