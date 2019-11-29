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
        </ul>
    </nav>
    <form class="d-flex flex-wrap" action="{{route('admin.promotions.start')}}" method="post">
        @csrf
        <div class="col-12 col-sm-6 border-bottom border-right-sm bdc-grey-400 pt-3">
            <h5>
                com.liveplayer.android
            </h5>

            <div class="form-group">
                <label for="com.liveplayer.android-title">Title:</label>
                <input type="text" class="form-control" name="com_liveplayer_android[title]" id="com.liveplayer.android-title" placeholder="event title">
            </div>

            <div class="form-group">
                <label for="com.liveplayer.android-img_url">Image Url:</label>
                <input type="text" class="form-control" name="com_liveplayer_android[imageUrl]" id="com.liveplayer.android-img_url" placeholder="image url">
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom bdc-grey-400 pt-3">
            <h5>
                com.mdc.iptvplayer.ios
            </h5>

            <div class="form-group">
                <label for="com.mdc.iptvplayer.ios-img_url">Image Url:</label>
                <input type="text" class="form-control" name="com_mdc_iptvplayer_ios[imageUrl]" id="com.mdc.iptvplayer.ios-img_url" placeholder="image url">
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom border-right-sm bdc-grey-400 pt-3">
            <h5>
                com.mdcmedia.liveplayer.ios
            </h5>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-img_url">Image Url:</label>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[imageUrl]" id="com.mdcmedia.liveplayer.ios-img_url" placeholder="image url">
            </div>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-promo_url">Promo Background Image Url:</label>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[promoBgUrl]" id="com.mdcmedia.liveplayer.ios-promo_url" placeholder="promo image image url">
            </div>

            <div class="form-group">
                <label for="com.mdcmedia.liveplayer.ios-promo_text">Promo Text:</label>
                <input type="text" class="form-control" name="com_mdcmedia_liveplayer_ios[promoText]" id="com.mdcmedia.liveplayer.ios-promo_text" placeholder="promo text">
            </div>
        </div>

        <div class="col-12 col-sm-6 border-bottom bdc-grey-400 pt-3">
            <h5>
                com.ustv.player
            </h5>

            <div class="form-group">
                <label for="com.ustv.player-img_url">Image Url:</label>
                <input type="text" class="form-control" name="com_ustv_player[imageUrl]" id="com.ustv.player-img_url" placeholder="image url">
            </div>
        </div>

        <button type="submit" class="btn-success-custom mx-auto my-3">Start Promo</button>
    </form>
@endsection
