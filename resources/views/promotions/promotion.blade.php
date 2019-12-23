@extends('layouts.main')
@section('title', 'Promotions')

@section('css')
    <link rel="stylesheet" href="/css/vendors/select2.min.css"/>
    <style>
        .hint-image {
            width: 180px;
            height: 320px;
        }

        .hint-image-desktop {
            width: 320px;
            height: 150px;
        }

        .tooltip-inner {
            max-width: none !important;
        }
    </style>
@endsection
@section('js')
    <script src="/js/vendors/bs-custom-file-input.min.js"></script>

    <script src="/js/promo/promo.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item active" aria-current="page" title="@if($isPromoRunning) Promotion running @else Promotion stopped @endif">Promotions
                <i class="fa fa-circle @if($isPromoRunning) text-success @else text-danger @endif"></i>
            </li>
            <li class="ml-auto">
                <form id="stop-form" action="{{route('admin.promotions.stop')}}" method="post">
                    @csrf
                    <button class="btn btn-danger" title="Stop Current Promotion">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    <form id="start-form" class="d-flex flex-wrap" action="{{route('admin.promotions.start')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-12 col-sm-6 border-bottom border-right-sm bdc-grey-400 pt-3">
            <h5>
                com.liveplayer.android (Live Stream Player Android)
            </h5>

            <div class="form-group">
                <label for="com.liveplayer.android-img_url">Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/live_player_image_url_hint.jpg' class='hint-image' alt='app start image dialog'>"></i>
                <input type="text" class="form-control" name="com_liveplayer_android[imageUrl]" id="com.liveplayer.android-img_url" value="{{json_decode($current->content??null)->com_liveplayer_android->imageUrl??""}}" placeholder="image url">
            </div>

            <div class="form-group">
                <label for="com.liveplayer.android-title">Config Title:</label>
                <input type="text" class="form-control" name="com_liveplayer_android[title]" id="com.liveplayer.android-title" value="{{json_decode($current->content??null)->com_liveplayer_android->title??""}}" placeholder="event title">
            </div>

            <div class="form-group">
                <label for="com.liveplayer.android-notification_title">Notification Title:</label>
                <input type="text" class="form-control" name="com_liveplayer_android[notification][title]" id="com.liveplayer.android-notification_title" value="{{json_decode($current->content??null)->com_liveplayer_android->notification->title??""}}" placeholder="notification title">
            </div>

            <div class="form-group">
                <label for="com.liveplayer.android-notification_url">Notification Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/notification_hint.jpg' class='hint-image' alt='app notification screen'>"></i>
                <input type="text" class="form-control" name="com_liveplayer_android[notification][url]" id="com.liveplayer.android-notification_url" value="{{json_decode($current->content??null)->com_liveplayer_android->notification->url??""}}" placeholder="notification image url">
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom bdc-grey-400 pt-3">
            <h5>
                com.mdc.iptvplayer.ios (IPTV iOS)
            </h5>

            <div class="form-group">
                <label for="com.mdc.iptvplayer.ios-img_url">Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/live_player_image_url_hint.jpg' class='hint-image' alt='app start image dialog'>"></i>
                <input type="text" class="form-control" name="com_mdc_iptvplayer_ios[imageUrl]" id="com.mdc.iptvplayer.ios-img_url" value="{{json_decode($current->content??null)->com_mdc_iptvplayer_ios->imageUrl??""}}" placeholder="image url">
            </div>

            <div class="form-group">
                <label for="com.mdc.iptvplayer.ios-notification_title">Notification Title:</label>
                <input type="text" class="form-control" name="com_mdc_iptvplayer_ios[notification][title]" id="com.mdc.iptvplayer.ios-notification_title" value="{{json_decode($current->content??null)->com_mdc_iptvplayer_ios->notification->title??""}}" placeholder="notification title">
            </div>

            <div class="form-group">
                <label for="com.mdc.iptvplayer.ios-notification_url">Notification Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/notification_hint.jpg' class='hint-image' alt='app notification screen'>"></i>
                <input type="text" class="form-control" name="com_mdc_iptvplayer_ios[notification][url]" id="com.mdc.iptvplayer.ios-notification_url" value="{{json_decode($current->content??null)->com_mdc_iptvplayer_ios->notification->url??""}}" placeholder="notification image url">
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom border-right-sm bdc-grey-400 pt-3">
            <h5>
                com.mdcmedia.liveplayer.ios (Live Player iOS)
            </h5>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-img_url">Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/live_player_image_url_hint.jpg' class='hint-image' alt='app start image dialog'>"></i>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[imageUrl]" id="com.mdcmedia.liveplayer.ios-img_url" value="{{json_decode($current->content??null)->com_mdcmedia_liveplayer_ios->imageUrl??""}}" placeholder="image url">
            </div>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-promo_url">Promo Background Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/live_player_promo_bg_hint.jpg' class='hint-image' alt='app start image dialog'>"></i>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[promoBgUrl]" id="com.mdcmedia.liveplayer.ios-promo_url" value="{{json_decode($current->content??null)->com_mdcmedia_liveplayer_ios->promoBgUrl??""}}" placeholder="promo image image url">
            </div>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-promo_text">Promo Text:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/live_player_promo_text_hint.jpg' class='hint-image' alt='app start image dialog'>"></i>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[promoText]" id="com.mdcmedia.liveplayer.ios-promo_text" value="{{json_decode($current->content??null)->com_mdcmedia_liveplayer_ios->promoText??""}}" placeholder="promo text">
            </div>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-notification_title">Notification Title:</label>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[notification][title]" id="com.mdcmedia.liveplayer.ios-notification_title" value="{{json_decode($current->content??null)->com_mdcmedia_liveplayer_ios->notification->title??""}}" placeholder="notification title">
            </div>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-notification_url">Notification Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/notification_hint.jpg' class='hint-image' alt='app notification screen'>"></i>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[notification][url]" id="com.mdcmedia.liveplayer.ios-notification_url" value="{{json_decode($current->content??null)->com_mdcmedia_liveplayer_ios->notification->url??""}}" placeholder="notification image url">
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom bdc-grey-400 pt-3">
            <h5>
                com.ustv.player (USTV Android)
            </h5>

            <div class="form-group">
                <label for="com.ustv.player-img_url">Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/live_player_image_url_hint.jpg' class='hint-image' alt='app start image dialog'>"></i>
                <input type="text" class="form-control" name="com_ustv_player[imageUrl]" id="com.ustv.player-img_url" value="{{json_decode($current->content??null)->com_ustv_player->imageUrl??""}}" placeholder="image url">
            </div>

            <label>Choose USTV Greet Image:</label>
            <div class="custom-file mb-3">
                <input type="file" name="com_ustv_player_greetImg" value="{{old('com_ustv_player_greetImg',"")}}" class="custom-file-input {{$errors->has('com_ustv_player_greetImg')?"is-invalid":""}}" id="com.ustv.player-greet_img" accept="image/*">
                <label class="custom-file-label" for="com.ustv.player-greet_img">Upgrade Greet Image</label>
                @if($errors->has('com_ustv_player_greetImg') )
                    <div class="invalid-feedback">{{ $errors->first('com_ustv_player_greetImg') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="com.ustv.player-notification_title">Notification Title:</label>
                <input type="text" class="form-control" name="com_ustv_player[notification][title]" id="com.ustv.player-notification_title" value="{{json_decode($current->content??null)->com_ustv_player->notification->title??""}}" placeholder="notification title">
            </div>

            <div class="form-group">
                <label for="com.ustv.player-notification_url">Notification Image Url:</label>
                <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/notification_hint.jpg' class='hint-image' alt='app notification screen'>"></i>
                <input type="text" class="form-control" name="com_ustv_player[notification][url]" id="com.ustv.player-notification_url" value="{{json_decode($current->content??null)->com_ustv_player->notification->url??""}}" placeholder="notification image url">
            </div>
        </div>

        <div class="col-12 border-bottom bdc-grey-400 pt-3">
            <h5>
                MDC Store
            </h5>

            <div class="d-flex flex-wrap mb-2">
                <div class="col-12 col-sm-6 border-right-sm bdc-grey-400">
                    <div class="form-group">
                        <label for="mdcstore-bg_url">Footer Background Url:</label>
                        <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/home_page_footer_bg_hint.png' class='hint-image-desktop' alt='home page footer promotion'>"></i>
                        <input type="text" class="form-control" name="mdc_store[backgroundUrl]" id="mdcstore-bg_url" value="{{$homePagePromotion->footerBackground??""}}" placeholder="mdcgate.com footer background url">
                    </div>

                    <div class="form-group">
                        <label for="mdcstore-left_url">Footer Left Image Url:</label>
                        <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/home_page_footer_bg_left_hint.png' class='hint-image-desktop' alt='home page footer left image'>"></i>
                        <input type="text" class="form-control" name="mdc_store[leftImgUrl]" id="mdcstore-left_url" value="{{$homePagePromotion->footerLeftImg??""}}" placeholder="mdcgate.com footer left image url">
                    </div>

                    <div class="form-group">
                        <label for="mdcstore-right_url">Footer Right Image Url:</label>
                        <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/home_page_footer_bg_right_hint.png' class='hint-image-desktop' alt='home page footer right image'>"></i>
                        <input type="text" class="form-control" name="mdc_store[rightImgUrl]" id="mdcstore-right_url" value="{{$homePagePromotion->footerRightImg??""}}" placeholder="mdcgate.com footer right image url">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="mdcstore-mobile_sale_price">Mobile License Key Price:</label>
                        <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/home_page_mobile_price_hint.png' class='hint-image-desktop' alt='mobile app price'>"></i>
                        <input type="text" class="form-control" name="mdc_store[mobile_sale_price]" id="mdcstore-mobile_sale_price" value="{{$homePagePromotion->mobileKey->salePrice??""}}" placeholder="mdcgate.com/apps/pricing mobile app sale price">
                    </div>

                    <div class="form-group">
                        <label for="mdcstore-desktop_sale_price">Desktop License Key Price:</label>
                        <i class="fa fa-question-circle text-info cur-p" data-toggle="tooltip" data-html="true" title="<img src='/images/promo_hint/home_page_desktop_price_hint.png' class='hint-image-desktop' alt='desktop app price'>"></i>
                        <input type="text" class="form-control" name="mdc_store[desktop_sale_price]" id="mdcstore-desktop_sale_price" value="{{$homePagePromotion->desktopKey->salePrice??""}}" placeholder="mdcgate.com/apps/pricing desktop app sale price">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mx-auto my-3">Start Promo</button>
    </form>
@endsection
