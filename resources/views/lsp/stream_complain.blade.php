@extends('layouts.main')
@section('title', 'Streams')
@section('css')
    <link rel="stylesheet" href="/css/vendors/animate.min.css">
@endsection
@section('js')
    <script src="/js/dist/delete.js"></script>
@endsection

@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.lsp.streams.index')}}">Management Stream</a>
            </li>
            <li class="breadcrumb-item active">
                Complains Streams
            </li>
        </ol>

    </nav>

    @if(isset($complainStreams))
        <div class="list table-responsive-sm ovX-a">
            <table class="table table-hover cell-inline" id="content">
                <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" id="selectAll" class="align-middle">
                    </th>
                    <th scope="col">Channel Code</th>
                    <th scope="col">Channel Name</th>
                    <th scope="col">Channel Owner</th>
                    <th scope="col">Reporter</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Report Time</th>
                    <th scope="col">Num</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complainStreams as $complain)
                    @if($complain->Num > 9)
                        <tr class="danger" data-toggle="modal" data-target="#exampleModal">
                    @elseif($complain->Num>1)
                        <tr class="warning" data-toggle="modal" data-target="#exampleModal">
                    @else
                        <tr data-toggle="modal" data-target="#exampleModal">
                            @endif
                            <th scope="row" class="align-middle">
                                <input type="checkbox" id="" class="align-middle select-row">
                            </th>
                            <td>{{$complain->ChannelCode}}</td>
                            <td style="white-space: normal">{{$complain->ChannelName}}</td>
                            <td>{{$complain->ChannelOwner}}</td>
                            <td>{{$complain->Reporter}}</td>
                            <td>{{$complain->Reason}}</td>
                            <td>{{$complain->Time}}</td>
                            <td>{{$complain->Num}}</td>
                        </tr>
                        @endforeach
                </tbody>

            </table>

        </div>
        {{$complainStreams->links('vendor.pagination.custom')}}
    @endif

    @include('lsp.layout_modal_suspend_stream')
    @include('layouts.deleteButton')
@endsection
