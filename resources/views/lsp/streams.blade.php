@extends('layouts.main')
@section('title', 'Streams')
@section('css')
@endsection

@section('js')
    <script src="/js/vendors/clipboard.min.js"></script>
    <script src="/js/vendors/popper.min.js"></script>
    <script src="/js/vendors/bootstrap.min.js"></script>
    <script src="/js/vendors/jquery.stickytableheaders.min.js"></script>
    <script src="/js/lsp/streams.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">Stream Management</li>
            <li class="breadcrumb-menu ml-auto mr-2">
                <a class="btn-success-custom text-white" title="Thêm Stream" href="{{route('admin.lsp.streams.create')}}">
                    <i class="material-icons align-middle">add</i>
                </a>
                <a class="btn btn-warning text-white" title="Complain Stream" href="{{route('admin.lsp.streams.complain')}}">
                    <i class="material-icons align-middle">warning</i>
                </a>
                <a class="btn-primary-custom text-white" title="Feature Stream" href="{{route('admin.lsp.streams.feature')}}">
                    <i class="material-icons align-middle">live_tv</i>
                </a>
            </li>
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
                    <th scope="col" class="cell-inline">Channel Name</th>
                    <th scope="col">URL</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Views</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Language</th>
                    <th scope="col">Likes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($songs as $song)
                    <tr data-href="{{route('admin.lsp.streams.show',$song->SongId)}}" @if($song->Copyright==1)class="danger"@endif>
                        {{--                    <tr>--}}
                        <th scope="row" class="align-middle">
                            <input type="checkbox" class="align-middle select-row">
                        </th>
                        <td>
                            <img src="{{$song->ImageURL}}" class="image-thumb image-fit img-thumbnail">
                        </td>
                        <td>{{$song->Code}}</td>
                        <td class="ellipsis-cell" title="{{$song->Name}}">
                            {{$song->Name}}
                            {{--                            <a href="{{route('admin.lsp.stream',$song->SongId)}}">{{$song->Name}}</a>--}}
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="ellipsis-text" id="clipboard-{{$song->Code}}">{{$song->URL}}</span>
                                <span class="except-redirect">
                                <button class="btn clipboard" type="button" data-clipboard-demo="" data-clipboard-target="#clipboard-{{$song->Code}}">
                                    <img src="https://clipboardjs.com/assets/images/clippy.svg" width="13" alt="Copy to clipboard">
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
                        <td>{{$song->AverageRating}}</td>
                        <td>{{$song->Language}}</td>
                        <td>{{number_format($song->likes_count)}}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        {{$songs->links('vendor.pagination.custom')}}
    @endif



@endsection
