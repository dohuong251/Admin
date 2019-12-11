@extends('layouts.main')
@section('title', 'Test Rules')
@section('css')
    <link rel="stylesheet" href="/css/vendors/select2.min.css"/>
    <link rel="stylesheet" href="/css/dist/fontawesome5.css"/>
    <style>
        .rule-stage .step:not(:first-child):not(:last-child) textarea:nth-child(odd) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top: 0;
        }

        .rule-stage .step:first-child textarea:nth-child(odd) {
            border-bottom-left-radius: 0;
        }

        .rule-stage .step:last-child textarea:nth-child(odd) {
            border-top-left-radius: 0;
            border-top: 0;
        }

        .rule-stage .step:not(:first-child):not(:last-child) textarea:nth-child(even) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-top: 0;
        }

        .rule-stage .step:first-child textarea:nth-child(even) {
            border-bottom-right-radius: 0;
        }

        .rule-stage .step:last-child textarea:nth-child(even) {
            border-top-right-radius: 0;
            border-top: 0;
        }
    </style>
@endsection
@section('js')
    @verbatim
        <script id="rule-template" type="text/x-handlebars-template">
            <div class="mt-3">
                <label for="match">Match:</label>
                <input name="Match" id="match" class="form-control w-auto" value="{{Match}}" required/>
            </div>
            <div class="mt-3">
                <label for="name">Name:</label>
                <input name="Name" id="name" class="form-control w-auto" value="{{Name}}" required/>
            </div>
            <div class="rule-stages mt-3">
                <label>Stages:</label>
                <button type="button" class="btn btn-success add-stage" title="add stage">
                    <i class="fa fa-plus"></i>
                </button>

                <div class="stage-container d-flex flex-wrap" id="stage-container">
                    {{#each Stages}}
                    {{> stageItemTemplate stageJSON=this}}
                    {{/each}}
                </div>
            </div>
        </script>
        <script id="stage-item-template" type="text/x-handlebars-template">
            <div class="mt-3 rule-stage cur-m col-12 col-md-6 border-bottom border-dark pb-3">
                {{#each stageJSON}}
                {{> stageJSONItemTemplate key=@key value=this}}
                {{/each}}
                {{! --                <button type="button" class="btn btn-success add-step mX-15 mt-1" title="add field">--}}
                {{! --                    <i class="fa fa-plus"></i>--}}
                {{! --                </button>--}}
            </div>
        </script>
        <script id="stage-json-item-template" type="text/x-handlebars-template">
            <div class="step d-flex">
                <div class="input-group">
                    <textarea class="form-control name noresize odd" type="text" rows="1">{{key}}</textarea>
                    <textarea class="form-control value resize-vertical even" type="text" {{#is_json_step_value value}}data-json-value="true" {{/is_json_step_value}} rows="1">{{#stringify_json_step_value value}}{{/stringify_json_step_value}}</textarea>
                </div>
                <div class="d-flex">
                    <i class="fa fa-times ml-2 cur-p remove-step cH-red-200" title="remove"></i>
                    <i class="fa fa-plus ml-2 cur-p add-step cH-green-200" title="add field"></i>
                </div>
            </div>
        </script>

        <script id="result-template" type="text/x-handlebars-template">
            {{#if url}}
            <div class="mb-2 mt-2 pX-10 text-success cur-p" id="result-link" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nhấp để sao chép"
                 data-clipboard-text="{{url}}">
                <b>
                    {{url}}
                </b>
            </div>
            {{/if}}
            <div id="step-results">
                {{#stepResults}}
                {{#is_step_exception step}}
                <div class="border rounded p-10 text-danger mb-2 mt-2">
                    <div>{{step}}</div>
                    <div class="step-result">{{result}}</div>
                </div>
                {{else}}
                <div class="border rounded p-10 mb-2 mt-2 clearfix step-result">
                    <i class="fa fa-caret-down float-right p-5 cur-p collapse-step-result transition-normal"></i>
                    <span class="transition-normal">{{step}}: </span>
                    <div class="d-inline">{{action}}</div>
                    <div class="text-success step-result-text transition-normal">{{result}}</div>
                </div>
                {{/is_step_exception}}
                {{/stepResults}}
            </div>
        </script>
    @endverbatim
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    <script src="/js/vendors/select2.min.js"></script>
    <script src="/js/vendors/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="/js/vendors/handlebars.min.js"></script>
    <script src="/js/vendors/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsonlint/1.6.0/jsonlint.min.js"></script>
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/tool/test_rule.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Tools
            </li>

            <li class="breadcrumb-item justify-content-center">
                Test Rule
            </li>

            <li class="ml-auto">

            </li>
        </ol>
    </nav>

    <button class="position-fixed t-15 z-1 btn btn-primary centerX" title="Sync Rule" id="update-rule" data-url="{{route('admin.tools.testRule.update_rule')}}">
        <i class="fas fa5-sync-alt"></i>
    </button>

    <div>
        <form id="rule-form" action="{{route('admin.tools.decrypt_url')}}" method="post">
            @csrf
            <div>
                <label for="url">Test Url:</label>
                <input id="url" class="form-control mt-1" name="url" placeholder="url (example: http://usnewslive.tv/showtime/)" value="{{old('url')}}" required/>
                @if($errors->has('url') )
                    <div class="text-danger">{{ $errors->first('url') }}</div>
                @endif
            </div>
            @if($defaultConfig)
                <div class="mt-3">
                    <label for="url">Page Rule:</label>
                    <select class="custom-select" id="select-page-rule">
                        <option value="0">New Page Rule</option>
                        @foreach(json_decode($defaultConfig)->Rules as $pageRule)
                            <option value="{{$pageRule->Match}}">{{$pageRule->Match}}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="mt-3 d-none">
                <div class="peers">
                    <label class="peer" for="rule">Test Rules:</label>
                    <div class="peer peer-greed text-right">
                        <div class="json-action cur-p d-inline">
                            <i class="fa fa-check fa-lg" title="JSON Validate" id="json-validate"></i>
                            <i class="fa fa-wrench fa-lg" title="Repair JSON" id="json-repair"></i>
                            <i class="fa fa-copy fa-lg" title="Copy" id="json-copy" data-clipboard-target="#rule"></i>
                            <i class="fa5 fa5-brackets-curly fa-lg" title="Beautify JSON" id="json-beautify"></i>
                        </div>
                    </div>
                </div>
                <textarea id="rule" class="form-control w-100 mt-1" name="rules" required>{{old('rules',$defaultConfig)??""}}</textarea>
                @if($errors->has('rules') )
                    <div class="text-danger">{{ $errors->first('rules') }}</div>
                @endif
            </div>
            <div id="page-rule" class="mt-3">

            </div>

            <button type="submit" class="btn-success-custom mt-3 mb-3 w-100">Test</button>
        </form>

        <div class="word-break-all" id="result"></div>
    </div>
@endsection
