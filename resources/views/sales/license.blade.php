@php
    include_once(Config::get("constant.LICENSE_KEY_CONFIG"));
@endphp
@extends('layouts.main')
@section('title', 'License Keys')
@section('css')
@endsection

@section('js')
    <script>let apps = @json($apps);</script>
    @verbatim
        <script id="send-new-license-key-form" type="text/text/x-handlebars-template">
            <div class="form-group">
                <label for="ApplicationId" class="control-label">ApplicationId:</label>
                <select name="ApplicationId" class="form-control" id="ApplicationId">
                    {{#each apps}}
                    <option value="{{@key}}" {{#ifEqual this appid}} selected {{/ifEqual}}>{{this}}</option>
                    {{/each}}
                </select>
            </div>

            <div class="form-group">
                <label for="resend_email" class="control-label">Customer Email</label>
                <input class="form-control" id="resend_email" name="Email" required="true">
            </div>
            <input type="hidden" name="User" value="root">
            <input type="hidden" name="Pass" value="mdc54321">
        </script>
        <script id="resend-license-key-form" type="text/text/x-handlebars-template">
            <div class="form-group">
                <label for="ApplicationId" class="control-label">ApplicationId:</label>
                <select name="ApplicationId" class="form-control" id="ApplicationId" disabled>
                    {{#each apps}}
                    <option value="{{@key}}" {{#ifEqual this appid}} selected {{/ifEqual}}>{{this}}</option>
                    {{/each}}
                </select>
            </div>

            <input class="form-control" id="resend_applicationid" name="ApplicationId" readonly="true" type="hidden" value="{{appid}}">

            <div class="form-group">
                <label for="resend_email" class="control-label">Customer Email</label>
                <input class="form-control" id="resend_email" name="Email" required="true" value="{{email}}">
            </div>
            <div class="form-group">
                <label for="resend_key" class="control-label">LicenseKey</label>
                <input class="form-control" id="resend_key" name="LicenseKey" readonly="true" value="{{licenseKey}}">
            </div>
            <input type="hidden" name="User" value="root">
            <input type="hidden" name="Pass" value="mdc54321">
        </script>
    @endverbatim
    <script src="/js/vendors/handlebars.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/vendors/sweetalert2.all.min.js"></script>
    <script src="/js/dist/ajax_setup_loading.js"></script>
    <script src="/js/sale/license.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">
                {{--                <a href="{{route('admin.sales.license')}}">License Keys</a>--}}
                License Keys
            </li>
            <li class="breadcrumb-menu ml-auto mr-2">
                <form action="{{route('admin.sales.license')}}" method="get">
                    <div class="input-group">
                        <select class="form-control" name="appid">
                            <option value="">Select App</option>
                            @foreach(\App\Models\Sale\LicenseKey::distinct()->select('ApplicationId')->orderBy('ApplicationId')->get() as $app)
                                <option value="{{$app->ApplicationId}}" {{Request()->get('appid')==$app->ApplicationId?"selected":""}}>{{$app->ApplicationId}}</option>
                            @endforeach
                        </select>
                        <select name="searchType" class="form-control">
                            <option value="CustomerEmail" {{Request()->get('searchType')=="CustomerEmail"?"selected":""}}>CustomerEmail</option>
                            <option value="LicenseId" {{Request()->get('searchType')=="LicenseId"?"selected":""}}>LicenseId</option>
                            <option value="OrderId" {{Request()->get('searchType')=="OrderId"?"selected":""}}>OrderId</option>
                            <option value="LicenseKey" {{Request()->get('searchType')=="LicenseKey"?"selected":""}}>LicenseKey</option>
                            <option value="TransactionId" {{Request()->get('searchType')=="TransactionId"?"selected":""}}>TransactionId</option>
                            <option value="CustomerName" {{Request()->get('searchType')=="CustomerName"?"selected":""}}>CustomerName</option>
                        </select>
                        <input name="query" aria-label="Search..." placeholder="Search..." class="form-control" value="{{Request()->get('query')}}"/>
                    </div>
                </form>
            </li>
        </ul>
    </nav>

    <button class="position-fixed t-15 z-1 btn btn-success centerX" data-toggle="modal" data-target="#sendLicenseModal">
        Send License Key
        <i class="fa fa-send"></i>
    </button>

    @if(isset($licenseKeys))

        <div class="list table-responsive-sm ovX-a">
            <table class="table table-hover" id="content">
                <thead>
                <tr>
                    <th scope="col">LicenseId</th>
                    <th scope="col">OrderId</th>
                    <th scope="col">ApplicationId</th>
                    <th scope="col">CustomerName</th>
                    <th scope="col">CustomerEmail</th>
                    <th scope="col">LicenseKey</th>
                    <th scope="col">State</th>
                    <th scope="col">PriceKey</th>
                    <th scope="col">PurchaseDate</th>
                    <th scope="col">ActiveDate</th>
                    <th scope="col">TransactionId</th>
                    <th scope="col">TransactionType</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($licenseKeys as $licenseKey)
                    {{--                    <tr {{$licenseKey->State==0? 'class=""':""}}>--}}
                    <tr>
                        <td>{{$licenseKey->LicenseId}}</td>
                        <td>{{$licenseKey->OrderId}}</td>
                        <td class="text-nowrap">{{$licenseKey->ApplicationId}}</td>
                        <td class="text-nowrap">{{$licenseKey->CustomerName}}</td>
                        <td>{{$licenseKey->CustomerEmail}}</td>
                        <td class="text-nowrap">{{$licenseKey->LicenseKey}}</td>
                        <td>
                            <a class="td-u-hover" href="{{route('admin.sales.license',array_merge(Request()->all(),['state'=>$licenseKey->State,'page'=>1]))}}">{{$licenseKey->State==0?"unused":"used"}}</a>
                        </td>
                        <td>{{$licenseKey->PriceKey}}</td>
                        <td class="text-nowrap">{{$licenseKey->PurchaseDate}}</td>
                        <td class="text-nowrap">{{$licenseKey->ActiveDate}}</td>
                        <td>{{$licenseKey->TransactionId}}</td>
                        <td>{{$licenseKey->TransactionType}}</td>
                        <td>
                            <a href="javascript:void(0)" data-resend="true" data-email="{{$licenseKey->CustomerEmail}}" data-applicationid="{{array_search($licenseKey->ApplicationId,$apps)??-1}}" data-license="{{$licenseKey->LicenseKey}}" data-toggle="modal" data-target="#sendLicenseModal">
                                <i class="fa fa-external-link-square"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="deleteLicenseKey(this,'{{route('admin.sales.license.destroy', $licenseKey->LicenseId)}}', '{{$licenseKey->LicenseKey}}')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        {{$licenseKeys->links('vendor.pagination.custom')}}
    @endif

    <div class="modal fade" id="sendLicenseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="send-license-form" class="modal-content" method="post" action="http://edge.mdcgate.com/sales/licensekey/api/send_a_licensekey_via_email.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send License Key</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ApplicationId" class="control-label">ApplicationId:</label>
                        <select name="ApplicationId" class="form-control" id="ApplicationId" disabled>
                            @foreach($apps as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input class="form-control" id="resend_applicationid" name="ApplicationId" readonly="true" type="hidden" value="3">

                    <div class="form-group">
                        <label for="resend_email" class="control-label">Customer Email</label>
                        <input class="form-control" id="resend_email" name="Email" required="true">
                    </div>
                    <div class="form-group">
                        <label for="resend_key" class="control-label">LicenseKey</label>
                        <input class="form-control" id="resend_key" name="LicenseKey" readonly="true">
                    </div>
                    <input type="hidden" name="User" value="root">
                    <input type="hidden" name="Pass" value="mdc54321">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
@endsection
