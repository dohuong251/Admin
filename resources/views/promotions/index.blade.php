@extends('layouts.main')
@section('title', 'Promotions')

@section('css')
@endsection

@section('js')
    <script src="/js/promo/promo.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page">Promotions</li>
            <li class="breadcrumb-menu ml-auto mr-2">
                <a class="btn-success-custom text-white" title="Tạo Mới" href="{{route('admin.lsp.streams.create')}}">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
    </nav>
    <div class="d-flex flex-wrap bdc-grey-400 bdw-2">
        <div class="col-12 col-sm-6 border-bottom border-right-sm bdc-grey-400 bdw-2">
            <h5>
                App Id: com.liveplayer.android
            </h5>
            <div class="mb-3">
                Device: MDC (3)
            </div>
            <div><b>Config name: message_web</b></div>
            <div class="form-group">
                <label for="com.liveplayer.android-message_web-title">title:</label>
                <input type="text" class="form-control" id="com.liveplayer.android-message_web-title" value="{{json_decode($liveStreamPlayer->first()->value)->title??""}}" placeholder="event title">
            </div>

            <div class="form-group">
                <label for="com.liveplayer.android-message_web-text">text:</label>
                <textarea type="text" class="form-control" id="com.liveplayer.android-message_web-text" placeholder="html content">{{json_decode($liveStreamPlayer->first()->value)->text??""}}</textarea>
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom bdc-grey-400 bdw-2 pt-3">
            <h5>
                App Id: com.mdc.iptvplayer.ios
            </h5>
            <div class="mb-3">
                Device: Google (0)
            </div>
            <div><b>Config name: message</b></div>
            <input name="type" value="{{json_decode($iptvIOS->first()->value)->type??1}}" hidden/>
            <div class="form-group">
                <label for="com.liveplayer.android-message_web-text">text:</label>
                <textarea type="text" class="form-control" id="com.liveplayer.android-message_web-text" placeholder="html content">{{json_decode($iptvIOS->first()->value)->text??""}}</textarea>
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom border-right-sm bdc-grey-400 bdw-2 pt-3">
            <h5>
                App Id: com.mdcmedia.liveplayer.ios
            </h5>
            <div class="mb-3">
                Device: Google (0)
            </div>

            @foreach($liveplayer as $lpConfig)
                <div><b>Config name: {{$lpConfig->name}}</b></div>
                @if(json_decode($lpConfig->value))
                    @foreach(json_decode($lpConfig->value) as $key=>$value)
                        <div class="form-group">
                            <label for="com.liveplayer.android-message_web-text">{{$key}}:</label>
                            <textarea type="text" class="form-control" id="com.liveplayer.android-message_web-text" placeholder="{{$lpConfig->name.' '.$key}}">{{$value??""}}</textarea>
                        </div>
                    @endforeach
                @else
                    <input type="text" class="form-control mb-3" id="com.liveplayer.android-message_web-text" placeholder="{{$lpConfig->name??""}}" value="{{$lpConfig->value}}"/>
                @endif
            @endforeach
        </div>

        <div class="col-12 col-sm-6 border-bottom bdc-grey-400 bdw-2 pt-3">
            <h5>
                App Id: com.ustv.player
            </h5>
            <div class="mb-3">
                Device: Google (0)
            </div>
            <div><b>Config name: message_web</b></div>
            <div class="form-group">
                <label for="com.liveplayer.android-message_web-text">html:</label>
                <textarea type="text" class="form-control" id="com.liveplayer.android-message_web-text" placeholder="html content">{{json_decode($ustv->first()->value)->html??""}}</textarea>
            </div>
        </div>
    </div>
@endsection
