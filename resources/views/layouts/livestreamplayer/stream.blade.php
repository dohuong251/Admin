@extends('layouts.main')
@section('title', 'Streams')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/admin/streams.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/style.css')}}">
@endsection

@section('script')
    <script>
        $('table tbody tr').click(function (event) {
            if (event.target.type !== 'checkbox' && !$(event.target).is('a')) {
                window.location.href = $(this).find('a').attr('href');
            }
        });
    </script>
    @endsection

@section('content')
<nav aria-label="breadcrumb">
    <ul class="breadcrumb bg-white border-bottom rounded-0">
        <li class="breadcrumb-item active" aria-current="page">Stream Management</li>
    </ul>

</nav>
    <div class="container-fluid">
        <div class="list">
            @if(isset($songs))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="selectAll" class="align-middle">
                        </th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Code</th>
                        <th scope="col" class="cell-inline">Channel Name</th>
                        <th scope="col">URL</th>
{{--                        <th scope="col">Owner</th>--}}
                        <th scope="col">Views</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Language</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($songs as $songs)
                    <tr>
                        <th scope="row" class="align-middle">
                            <input type="checkbox" id="selectStream" class="align-middle">
                        </th>
                        <td>
                            <img src="{{$songs->ImageURL}}" width="70" height="40" alt="">
                        </td>
                        <td>{{$songs->Code}}</td>
                        <td>
                            <a href="{{route('admin.livestreamplayer.stream',$songs->SongId)}}">{{$songs->Name}}</a>
                        </td>
                        <td class="ellipsis-cell" style="max-width:50vw">{{$songs->URL}}</td>
{{--                        <td>--}}
{{--                            {{$song->Owner}}--}}
{{--                        </td>--}}
                        <td>{{$songs->ViewByAll}}</td>
                        <td>{{$songs->RateCount}}</td>
                        <td>{{$songs->Language}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
{{--                {{$songs->links('vendor.pagination.custom')}}--}}

                @endif
        </div>

    </div>


    @endsection
