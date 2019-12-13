@extends('layouts.main')
@section('title', 'Notification')
@section('css')
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
@endsection
@section('js')

    <script src="/js/vendors/spin.min.js"></script>
    <script src="/js/vendors/ladda.min.js"></script>
    <script src="/js/dist/delete.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Tools
            </li>

            <li class="breadcrumb-item justify-content-center">
                Notifications
            </li>

            <li class="ml-auto">
                <a href="{{route('admin.tools.notification.create')}}" class="btn btn-success" title="add notification">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ol>
    </nav>

    @if($notifications)
        <div>
            <div class="list">
                <table class="table table-hover table-responsive" id="content">
                    <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="selectAll" class="align-middle">
                        </th>
                        <th scope="col">AppId</th>
                        <th scope="col">Type</th>
                        <th scope="col">Platform</th>
                        <th scope="col">Notification</th>
                        <th scope="col">StartDate</th>
                        <th scope="col">ExpiredDate</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr data-href="{{route('admin.tools.notification.show',$notification->Id)}}">
                            <th scope="row" class="align-middle">
                                <input type="checkbox" class="align-middle select-row" data-id="{{$notification->Id}}">
                            </th>
                            <td>{{$notification->AppId}}</td>
                            <td>
                                @switch($notification->Type)
                                    @case(0)
                                    Notification
                                    @break
                                    @case(1)
                                    Update
                                    @break
                                    @case(2)
                                    Promotion
                                    @break
                                    @case(3)
                                    More App
                                    @break
                                    @default
                                    {{$notification->Type}}
                                @endswitch
                            </td>
                            <td>{{$notification->Platform}}</td>
                            <td class="text-break">{{$notification->Notification}}</td>
                            <td class="text-nowrap">{{$notification->StartDate}}</td>
                            <td>{{$notification->ExpiredDate}}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    @endif
    @include('layouts.deleteButton')
@endsection
