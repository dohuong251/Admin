@extends('layouts.main')
@section('title', 'Notification')
@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css"/>
    <link rel="stylesheet" href="/css/vendors/ladda.min.css"/>
    <link rel="stylesheet" href="/css/vendors/animate.min.css"/>
    <style>
        .daterangepicker.single .drp-buttons {
            display: block !important;
        }

        .daterangepicker {
            padding: 0 !important;
        }
    </style>
@endsection
@section('js')
    <script>
        let formActionSuccess = false;
        @if(session()->get('actionSuccess'))
            @verbatim
            formActionSuccess = true;
        @endverbatim
        @endif
    </script>
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="/js/vendors/sweetalert2.all.min.js"></script>
    <script src="/js/vendors/ladda.min.js"></script>
    <script src="/js/dist/delete.js"></script>
    <script src="/js/tool/notification_edit.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Tools
            </li>

            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.tools.notification')}}">Notifications</a>
            </li>

            <li class="breadcrumb-item justify-content-center">
                Edit Notifications
            </li>
        </ol>
    </nav>

    <div class="text-danger text-center"><b>{{$errors->error->first()}}</b></div>
    @if($notification)
        <form method="post" action="{{route('admin.tools.notification.update',$notification->Id)}}">
            @method('PUT')
            @csrf
            <div class="peers">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="appid">AppId:</label>
                        <input class="form-control {{$errors->has('AppId')?'is-invalid':''}}" name="AppId" id="appid" value="{{old('AppId',$notification->AppId)}}" placeholder="app id" required/>
                        @if($errors->has('AppId'))
                            <div class="text-danger">{{$errors->first('AppId')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="custom-select {{$errors->has('Type')?'is-invalid':''}}" name="Type" id="type" required>
                            <option value="0" {{old('Type',$notification->Type)==0?'selected':''}}>Notification</option>
                            <option value="1" {{old('Type',$notification->Type)==1?'selected':''}}>Update</option>
                            <option value="2" {{old('Type',$notification->Type)==2?'selected':''}}>Promotion</option>
                            <option value="3" {{old('Type',$notification->Type)==3?'selected':''}}>More App</option>
                        </select>
                        @if($errors->has('Type'))
                            <div class="text-danger">{{$errors->first('Type')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="platform">Platform:</label>
                        <select class="custom-select {{$errors->has('Platform')?'is-invalid':''}}" name="Platform" id="platform" required>
                            <option value="Android" {{old('Platform',$notification->Platform)=="Android"?'selected':''}}>Android</option>
                            <option value="iOS" {{old('Platform',$notification->Platform)=="iOS"?'selected':''}}>iOS</option>
                        </select>
                        @if($errors->has('Platform'))
                            <div class="text-danger">{{$errors->first('Platform')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start Date:</label>
                        <input class="form-control {{$errors->has('StartDate')?'is-invalid':''}}" name="StartDate" id="start-date" value="{{old('StartDate',$notification->StartDate)}}" placeholder="Start Date (Y-m-d)" required/>
                        @if($errors->has('StartDate'))
                            <div class="text-danger">{{$errors->first('StartDate')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="expired-date">Expired Date:</label>
                        <input class="form-control {{$errors->has('ExpiredDate')?'is-invalid':''}}" name="ExpiredDate" id="expired-date" value="{{old('ExpiredDate',$notification->ExpiredDate)}}" placeholder="Expired Date (Y-m-d)"/>
                        @if($errors->has('ExpiredDate'))
                            <div class="text-danger">{{$errors->first('ExpiredDate')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    @if($errors->has('Notification'))
                        <div class="text-danger">{{$errors->first('Notification')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="notification-title">Notification Title:</label>
                        <input class="form-control {{$errors->has('Notification.title')?'is-invalid':''}}" name="Notification[title]" id="notification-title" value="{{old('Notification',json_decode($notification->Notification, true))['title']??""}}" placeholder="Notification Title" required/>
                        @if($errors->has('Notification.title'))
                            <div class="text-danger">{{$errors->first('Notification.title')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="notification-text">Notification Text:</label>
                        <input class="form-control {{$errors->has('Notification.text')?'is-invalid':''}}" name="Notification[text]" id="notification-text" value="{{old('Notification',json_decode($notification->Notification,true))['text']??""}}" placeholder="Notification Text" required/>
                        @if($errors->has('Notification.text'))
                            <div class="text-danger">{{$errors->first('Notification.text')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="notification-button-title">Notification Button Title:</label>
                        <input class="form-control" name="Notification[button][title]" id="notification-button-title" value="{{old('Notification',json_decode($notification->Notification,true))['button']['title']??""}}" placeholder="Notification Button Title"/>
                    </div>
                    <div class="form-group">
                        <label for="notification-button-link">Notification Button Link:</label>
                        <input class="form-control" name="Notification[button][link]" id="notification-button-link" value="{{old('Notification',json_decode($notification->Notification,true))['button']['link']??""}}" placeholder="Notification Button Link"/>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-success-custom m-auto">
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    @else
        <div>
            Không tìm thấy thông báo
        </div>
    @endif
@endsection
