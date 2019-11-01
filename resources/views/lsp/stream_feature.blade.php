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
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.lsp.streams.index')}}">Management Stream</a>
            </li>
            <li class="breadcrumb-item active">
                Feature Streams
            </li>
        </ul>
    </nav>
    @if(isset($features))
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
                    <th scope="col">Views</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Language</th>
                    <th scope="col">Likes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($features as $feature)
                    <tr data-href="{{route('admin.lsp.streams.show',$feature->SongId)}}">
                        {{--                    <tr>--}}
                        <th scope="row" class="align-middle">
                            <input type="checkbox" class="align-middle select-row">
                        </th>
                        <td>
                            <img src="{{$feature->songs->ImageURL}}" class="image-thumb image-fit img-thumbnail">
                        </td>
                        <td>{{$feature->songs->Code}}</td>
                        <td class="ellipsis-cell" title="{{$feature->songs->Name}}">
                            {{$feature->songs->Name}}
                            {{--                            <a href="{{route('admin.lsp.stream',$feature->SongId)}}">{{$feature->Name}}</a>--}}
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="ellipsis-text" id="clipboard-{{$feature->songs->Code}}">{{$feature->songs->URL}}</span>
                                <span class="except-redirect">
                                <button class="btn clipboard" type="button" data-clipboard-demo="" data-clipboard-target="#clipboard-{{$feature->Code}}">
                                    <img src="https://clipboardjs.com/assets/images/clippy.svg" width="13" alt="Copy to clipboard">
                                </button>
                            </span>
                            </div>
                        </td>
                        <td>{{number_format($feature->songs->ViewByAll)}}</td>
                        <td>{{$feature->songs->AverageRating}}</td>
                        <td>{{$feature->songs->Language}}</td>
                        <td>{{number_format($feature->likes_count)}}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        {{$features->links('vendor.pagination.custom')}}
    @endif



@endsection
