<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\model;
use App\Models\Promotion;
use App\Models\Tool\Config;
use DB;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
//    public function index()
//    {
//        return view('promotions.index', [
//            'liveStreamPlayer' => Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])->get(),
//            'iptvIOS' => Config::where([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])->get(),
//            'liveplayer' => Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0]])->whereIn('name', ['message', 'promo_background', 'promo_text'])->get(),
//            'ustv' => Config::where([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])->get(),
//        ]);
//    }

    public function index()
    {
        return view('promotions.promotion', [
            'current' => Promotion::orderBy('id', 'desc')->first()
        ]);
    }

    public function startPromo(Request $request)
    {
        if ($request->get("com_liveplayer_android")["title"] || $request->get("com_liveplayer_android")["imageUrl"]) {
            $promoConfig = array(
                'button' =>
                    array(
                        'title' => 'View',
                        'link' => 'http://edge.mdcgate.com/sales/subscription/buy.php?HiddenButton=1&ApplicationId=Live%20Media%20Player&mode=licensekey',
                    ),
            );
            if ($request->get("com_liveplayer_android")["title"]) $promoConfig["title"] = $request->get("com_liveplayer_android")["title"];
            if ($request->get("com_liveplayer_android")["imageUrl"]) {
                $imageUrl = $request->get("com_liveplayer_android")["imageUrl"];
                $promoConfig["text"] = "<!DOCTYPE html><html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"http://edge.mdcgate.com/sales/subscription/buy.php?HiddenButton=1&ApplicationId=Live%20Media%20Player&mode=licensekey\"><img  src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
            }
            Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])
                ->update(['value' => json_encode($promoConfig)]);
        }

        if ($request->get('com_mdc_iptvplayer_ios')['imageUrl']) {
            $promoConfig = array(
                'type' => 1,
            );
            $imageUrl = $request->get("com_mdc_iptvplayer_ios")["imageUrl"];
            $promoConfig["text"] = " <!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"> <a href=\"iptv://?action=upgrade\"><img src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";

            Config::where([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])
                ->update(['value' => json_encode($promoConfig)]);
        }

        if ($request->get('com_mdcmedia_liveplayer_ios')['imageUrl']) {
            $promoConfig = array(
                'text' => 'Dear Users ,
We have just released a brand new IPTV application - IPTV Player. Please support us by downloading this application now !',
            );
            $imageUrl = $request->get('com_mdcmedia_liveplayer_ios')['imageUrl'];
            $promoConfig["html"] = "<!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"lsp://?action=upgrade\"><img src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'message']])
                ->update(['value' => json_encode($promoConfig)]);
        }

        if ($request->get('com_mdcmedia_liveplayer_ios')['promoBgUrl']) {
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_background']])
                ->update(['value' => $request->get('com_mdcmedia_liveplayer_ios')['promoBgUrl']]);
        }
        if ($request->get('com_mdcmedia_liveplayer_ios')['promoText']) {
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_text']])
                ->update(['value' => $request->get('com_mdcmedia_liveplayer_ios')['promoText']]);
        }

        if ($request->get('com_ustv_player')['imageUrl']) {
            $promoConfig = array();
            $imageUrl = $request->get('com_ustv_player')['imageUrl'];
            $promoConfig["html"] = "<!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"ustvupgrade://?action=upgrade\"><img  style='border-radius: 10px;' src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
            Config::where([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])
                ->update(['value' => json_encode($promoConfig)]);
        }

        Promotion::query()->delete();
        $prmotion = new Promotion();
        $prmotion->content = json_encode($request->except('_token'));
        $prmotion->save();

        return back();
    }

    public function stopPromo(Request $request)
    {
        Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])
            ->orWhere([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])
            ->orWhere([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'message']])
            ->orWhere([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_background']])
            ->orWhere([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_text']])
            ->orWhere([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])
            ->update(['value' => '']);
        Promotion::query()->delete();
        return back();
    }
    //

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
    }

    /**
     * @return model sẽ thực hiện xóa hàng loạt trong hàm delete
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
    }
}
