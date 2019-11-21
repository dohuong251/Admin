@extends('layouts.main')
@section('title', 'Promotions')
@section('css')

@endsection
@section('js')

@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">Promotions</li>
            <li class="breadcrumb-menu ml-auto mr-2">
                <a class="btn-success-custom text-white" title="Tạo Mới" href="{{route('admin.lsp.streams.create')}}">
                    <i class="fa fa-plus"></i>
                </a>
{{--                <a class="btn btn-warning text-white" title="Complain Stream" href="{{route('admin.lsp.streams.complain')}}">--}}
{{--                    <i class="material-icons align-middle">warning</i>--}}
{{--                </a>--}}
{{--                <a class="btn-primary-custom text-white" title="Feature Stream" href="{{route('admin.lsp.streams.feature')}}">--}}
{{--                    <i class="material-icons align-middle">live_tv</i>--}}
{{--                </a>--}}
            </li>
        </ul>
    </nav>
    <div class="list">
        <table class="table table-hover" id="content">
            <thead>
            <tr>
                <th scope="col">
                    <input type="checkbox" id="selectAll" class="align-middle">
                </th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr data-href="{{''}}">
                <th scope="row" class="align-middle">
                    <input type="checkbox" class="align-middle select-row" data-id="{{''}}">
                </th>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
