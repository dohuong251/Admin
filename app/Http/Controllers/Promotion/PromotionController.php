<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\model;
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
        return view('promotions.promotion');
    }

    public function startPromo(Request $request)
    {
        if ($request->get("com_liveplayer_android")["title"] || $request->get("com_liveplayer_android")["imageUrl"]) {
            $lspConfig = Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])->get()->first();

            if (json_decode($lspConfig->value)) {
                $jsonValue = json_decode($lspConfig->value);
                if ($request->get("com_liveplayer_android")["title"]) $jsonValue->title = $request->get("com_liveplayer_android")["title"];
                if ($request->get("com_liveplayer_android")["imageUrl"]) {
                    $imageUrl = $request->get("com_liveplayer_android")["imageUrl"];
                    $jsonValue->text = "<!DOCTYPE html><html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"http://edge.mdcgate.com/sales/subscription/buy.php?HiddenButton=1&ApplicationId=Live%20Media%20Player&mode=licensekey\"><img  src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
                }
                $lspConfig->value = json_encode($jsonValue);
                Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])
                    ->update(['value' => $lspConfig->value]);
            }
        }

        if ($request->get('com_mdc_iptvplayer_ios')['imageUrl']) {
            $iptvConfig = Config::where([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])->get()->first();
            if (json_decode($iptvConfig->value)) {
                $jsonValue = json_decode($iptvConfig->value);

                if ($request->get("com_mdc_iptvplayer_ios")["imageUrl"]) {
                    $imageUrl = $request->get("com_mdc_iptvplayer_ios")["imageUrl"];
                    $jsonValue->text = " <!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"> <a href=\"iptv://?action=upgrade\"><img src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
                }
                $iptvConfig->value = json_encode($jsonValue);
                Config::where([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])
                    ->update(['value' => $iptvConfig->value]);
            }
        }

        if ($request->get('com_mdcmedia_liveplayer_ios')['imageUrl']) {
            $livePlayerConfig = Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'message']])->get()->first();
            if (json_decode($livePlayerConfig->value)) {
                $jsonValue = json_decode(($livePlayerConfig->value));
                $imageUrl = $request->get('com_mdcmedia_liveplayer_ios')['imageUrl'];
                $jsonValue->html = "<!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"lsp://?action=upgrade\"><img src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
                $livePlayerConfig->value = json_encode($jsonValue);
                Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'message']])
                    ->update(['value' => $livePlayerConfig->value]);
            }
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
            $ustvConfig = Config::where([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])->get()->first();
            if (json_decode($ustvConfig->value)) {
                $jsonValue = json_decode(($ustvConfig->value));
                $imageUrl = $request->get('com_ustv_player')['imageUrl'];
                $jsonValue->html = "<!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"ustvupgrade://?action=upgrade\"><img  style='border-radius: 10px;' src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
                $ustvConfig->value = json_encode($jsonValue);
                Config::where([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])
                    ->update(['value' => $ustvConfig->value]);
            }
        }
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
