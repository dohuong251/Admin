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
    <link href="/css/vendors/jsoneditor.min.css" rel="stylesheet" type="text/css">
@endsection
@section('js')
    @verbatim
        <script id="result-template" type="text/x-handlebars-template">
            <b class="my-2 text-center">Kết Quả</b>
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
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>--}}
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsonlint/1.6.0/jsonlint.min.js"></script>
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/vendors/jsoneditor.min.js"></script>
    <script src="/js/tool/test_rule.js"></script>
    <script>
        const container = document.getElementById("jsoneditor")
        const options = {mode: "code"}
        const editor = new JSONEditor(container, options)

        // set json
        const initialJson = JSON.parse(@json($defaultConfig))
        editor.set(initialJson)

        window.editor = editor;
    </script>
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

    <div>
        <form id="rule-form" action="{{route('admin.tools.decrypt_url')}}" method="post">
            @csrf
            <div>
                <label for="url">Parse Url:</label>
                <input id="url" class="form-control mt-1" name="url" placeholder="url (example: http://usnewslive.tv/showtime/)" value="{{old('url')}}" required/>
                @if($errors->has('url') )
                    <div class="text-danger">{{ $errors->first('url') }}</div>
                @endif
            </div>
            @if($defaultConfig)
                <div class="mt-3">
                    <label for="url">Rules:</label>
                    <div id="jsoneditor" style="height: 400px;"></div>
                </div>
            @endif
            <div class="my-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa5-check mr-2"></i>
                    Parse
                </button>
                <button type="button" class="btn btn-primary" title="Sync Rule" id="update-rule" data-url="{{route('admin.tools.testRule.update_rule')}}">
                    <i class="fas fa5-sync-alt mr-2"></i>
                    Cập Nhật Luật
                </button>
            </div>
        </form>

        <div class="word-break-all" id="result"></div>
    </div>
@endsection
