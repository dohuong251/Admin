@extends('layouts.main')
@section('title', 'Streams')
@section('css')
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
@endsection

@section('js')

    <script src="/js/vendors/spin.min.js"></script>
    <script src="/js/vendors/ladda.min.js"></script>
    <script src="/js/vendors/clipboard.min.js"></script>
    <script src="/js/vendors/popper.min.js"></script>
    <script src="/js/vendors/bootstrap.min.js"></script>
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/dist/delete.js"></script>
    <script src="/js/lsp/streams.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">Stream Management</li>
        </ul>
    </nav>
    @if(isset($songs))
        <div class="list table-responsive-sm ovX-a">
            <table class="table table-hover" id="content">
                <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" id="selectAll" class="align-middle">
                    </th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Code</th>
                    <th scope="col" class="text-nowrap">Channel Name</th>
                    <th scope="col">URL</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Views</th>
                    <th scope="col">Reporter</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Time</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($songs as $song)
                    <tr data-href="{{route('admin.lsp.streams.show',$song->SongId)}}" @if($song->Copyright==1)class="danger"@endif>
                        {{--                    <tr>--}}
                        <th scope="row" class="align-middle">
                            <input type="checkbox" class="align-middle select-row" data-id="{{$song->SongId}}">
                        </th>
                        <td>
                            <img data-src="{{$song->ImageURL}}" class="image-thumb image-fit img-thumbnail">
                        </td>
                        <td>{{$song->Code}}</td>
                        <td class="ellipsis-cell" title="{{$song->Name}}">
                            {{$song->Name}}
                            {{--                            <a href="{{route('admin.lsp.stream',$song->SongId)}}">{{$song->Name}}</a>--}}
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="ellipsis-text" id="clipboard-{{$song->Code}}" title="{{$song->URL}}">{{$song->URL}}</span>
                                <span class="except-redirect">
                                <button class="btn clipboard" type="button" data-clipboard-demo="" data-clipboard-target="#clipboard-{{$song->Code}}">
                                    <img data-src="/images/icon/clippy.svg" width="13" alt="Copy to clipboard">
                                </button>
                            </span>
                            </div>
                        </td>
                        <td>
                            @if($song->users)
                                <a class="td-u-hover td-u-focus" href="{{route('admin.lsp.user.show',$song->users->UserId)}}">{{$song->users->Nickname}}</a>
                            @endif
                        </td>
                        <td>{{number_format($song->ViewByAll)}}</td>
                        <td>{{$song->Nickname}}</td>
                        <td>{{$song->Reason}}</td>
                        <td>{{$song->DeleteDate}}</td>
                        <td>
                            @if($song->Copyright == 0)
                                <a href="{{route('admin.lsp.review_copyright',['SongId'=>$song->SongId,'Copyright'=>1])}}"><i class="fa fa-ban"></i></a>
                            @endif
                            <a href="{{route('admin.lsp.review_copyright',['SongId'=>$song->SongId,'Copyright'=>0])}}"><i class="fa fa-history"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        {{$songs->links('vendor.pagination.custom')}}
        @include('lsp.layout_modal_suspend_stream')
        @include('layouts.deleteButton')
        {{--        @include('layouts.deleteGroupButton')--}}
    @endif

@endsection
