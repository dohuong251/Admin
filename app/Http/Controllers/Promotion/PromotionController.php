<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\model;
use App\Models\Promotion;
use App\Models\Tool\Config;
use DB;
use DOMDocument;
use DOMXPath;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;

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

    /**
     * @var string
     */
    private $promoConfigFile;
    /**
     * @var string
     */
    private $ustvUpgradeGreetImg;
    /**
     * @var \GuzzleHttp\Client
     */
    private $notificationRequest;

    public function __construct()
    {
        $this->promoConfigFile = base_path() . "/config/mdcgate_config.json";
        $this->ustvUpgradeGreetImg = "/home/www/edge.mdcgate.com/html/sales/subscription/images/";
        $this->notificationRequest = new \GuzzleHttp\Client([
            'auth' => ['bkyiztnapgjblisicaim', 'oolwylifcbezouradtlw']
        ]);
//        $this->ustvUpgradeGreetImg = base_path()."/";
    }

    public function index()
    {
        if (file_exists($this->promoConfigFile) && ($fp = file_get_contents($this->promoConfigFile)) !== false) {
            $promoConfig = json_decode($fp);
        }
        return view('promotions.promotion', [
            'current' => Promotion::withTrashed()->orderBy('id', 'desc')->first(),
            'homePagePromotion' => $promoConfig ?? null,
            'isPromoRunning' => $promoConfig->promotion || Promotion::count() ?? false
        ]);
    }

    public function startPromo(Request $request)
    {
        $request->validate([
            "com_ustv_player_greetImg" => "nullable|file|image"
        ], [
            "com_ustv_player_greetImg.image" => "Greet image wrong mime type",
            "com_ustv_player_greetImg.file" => "Greet image isn't file"
        ]);

        DB::connection('mysql_tool_connection')->transaction(function () use ($request) {
            if ($request->get("com_liveplayer_android")["title"] != null || $request->get("com_liveplayer_android")["imageUrl"] != null) {
                $promoConfig = array(
                    'type' => 1,
                    'button' =>
                        array(
                            'title' => 'View',
                            'link' => 'http://edge.mdcgate.com/sales/subscription/buy.php?HiddenButton=1&ApplicationId=Live%20Media%20Player&mode=licensekey',
                        ),
                );
                if ($request->get("com_liveplayer_android")["title"] != null) $promoConfig["title"] = $request->get("com_liveplayer_android")["title"];
                if ($request->get("com_liveplayer_android")["imageUrl"] != null) {
                    $imageUrl = $request->get("com_liveplayer_android")["imageUrl"];
                    $promoConfig["text"] = "<!DOCTYPE html><html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"http://edge.mdcgate.com/sales/subscription/buy.php?HiddenButton=1&ApplicationId=Live%20Media%20Player&mode=licensekey\"><img  src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";
                }
                if (Config::where(['id_application' => 'com.liveplayer.android', 'name' => 'message_web', 'device' => 3])->count()) {
                    Config::where(['id_application' => 'com.liveplayer.android', 'name' => 'message_web', 'device' => 3])
                        ->update(['value' => json_encode($promoConfig)]);
                } else {
                    Config::insert(['id_application' => 'com.liveplayer.android', 'name' => 'message_web', 'device' => 3, 'value' => json_encode($promoConfig)]);
                }
            } else {
                Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])
                    ->update(['value' => ""]);
            }

            if ($request->get('com_mdc_iptvplayer_ios')['imageUrl'] != null) {
                $promoConfig = array(
                    'type' => 1,
                );
                $imageUrl = $request->get("com_mdc_iptvplayer_ios")["imageUrl"];
                $promoConfig["text"] = " <!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"> <a href=\"iptv://?action=upgrade\"><img src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";

                if (Config::where(['id_application' => 'com.mdc.iptvplayer.ios', 'name' => 'message', 'device' => 0])->count()) {
                    Config::where(['id_application' => 'com.mdc.iptvplayer.ios', 'name' => 'message', 'device' => 0])
                        ->update(['value' => json_encode($promoConfig)]);
                } else {
                    Config::insert(['id_application' => 'com.mdc.iptvplayer.ios', 'name' => 'message', 'device' => 0, 'value' => json_encode($promoConfig)]);
                }
            } else {
                Config::where([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])
                    ->update(['value' => ""]);
            }

            if ($request->get('com_mdcmedia_liveplayer_ios')['imageUrl'] != null) {
                $promoConfig = array(
                    'text' => 'Dear Users ,
We have just released a brand new IPTV application - IPTV Player. Please support us by downloading this application now !',
                );
                $imageUrl = $request->get('com_mdcmedia_liveplayer_ios')['imageUrl'];
                $promoConfig["html"] = "<!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"lsp://?action=upgrade\"><img src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";

                if (Config::where(['id_application' => 'com.mdcmedia.liveplayer.ios', 'device' => 0, 'name' => 'message'])->count()) {
                    Config::where(['id_application' => 'com.mdcmedia.liveplayer.ios', 'device' => 0, 'name' => 'message'])
                        ->update(['value' => json_encode($promoConfig)]);
                } else {
                    Config::insert(['id_application' => 'com.mdcmedia.liveplayer.ios', 'device' => 0, 'name' => 'message', 'value' => json_encode($promoConfig)]);
                }

            } else {
                Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'message']])
                    ->update(['value' => ""]);
            }

//        if ($request->get('com_mdcmedia_liveplayer_ios')['promoBgUrl']) {
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_background']])
                ->update(['value' => $request->get('com_mdcmedia_liveplayer_ios')['promoBgUrl']]);
//        }
//        if ($request->get('com_mdcmedia_liveplayer_ios')['promoText']) {
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_text']])
                ->update(['value' => $request->get('com_mdcmedia_liveplayer_ios')['promoText']]);
//        }
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'enable_promo']])
                ->update(['value' => 1]);

            if ($request->get('com_ustv_player')['imageUrl'] != null) {
                $promoConfig = array(
                    'type' => 1
                );
                $imageUrl = $request->get('com_ustv_player')['imageUrl'];
                $promoConfig["html"] = "<!DOCTYPE html>\r\n<html>\r\n    <meta charset=\"utf-8\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<body style=\"margin:0;\"><a href=\"ustvupgrade://?action=upgrade\"><img  style='border-radius: 10px;' src=\"$imageUrl\" alt=\"Smiley face\" width=\"100%\" height=\"100%\"></a></body>\r\n</html>";

                if (Config::where(['id_application' => 'com.ustv.player', 'name' => 'message_web', 'device' => 0])->count()) {
                    Config::where(['id_application' => 'com.ustv.player', 'name' => 'message_web', 'device' => 0])
                        ->update(['value' => json_encode($promoConfig)]);
                } else {
                    Config::insert(['id_application' => 'com.ustv.player', 'name' => 'message_web', 'device' => 0, 'value' => json_encode($promoConfig)]);
                }

            } else {
                Config::where([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])
                    ->update(['value' => ""]);
            }
        }, 5);

        if (file_exists($this->promoConfigFile) && ($fp = file_get_contents($this->promoConfigFile)) !== false) {
            $promoConfig = json_decode($fp, true);
            $promoConfig["promotion"] = true;
            $promoConfig["footerBackground"] = $request->get('mdc_store')['backgroundUrl'];
            $promoConfig["footerLeftImg"] = $request->get('mdc_store')['leftImgUrl'];
            $promoConfig["footerRightImg"] = $request->get('mdc_store')['rightImgUrl'];
            $promoConfig["footerCenterImg"] = $request->get('mdc_store')['centerImgUrl'];
            $promoConfig["mobileKey"]["salePrice"] = $request->get('mdc_store')['mobile_sale_price'];
            $promoConfig["desktopKey"]["salePrice"] = $request->get('mdc_store')['desktop_sale_price'];
            file_put_contents("$this->promoConfigFile", json_encode($promoConfig, JSON_PRETTY_PRINT));
        }

        if ($request->hasFile('com_ustv_player_greetImg')) {
            if (is_dir($this->ustvUpgradeGreetImg)) {
                file_put_contents($this->ustvUpgradeGreetImg . "upgrade_greet.jpg", $request->file('com_ustv_player_greetImg')->get());
            }
        }

        try {
            // tạo notification
            $notificationIds = $this->notificationRequest->request('POST', 'http://visearch.net/adminPromo/notification.php', [
                'form_params' => [
                    'com_liveplayer_android' => $request->get('com_liveplayer_android'),
                    'com_mdc_iptvplayer_ios' => $request->get('com_mdc_iptvplayer_ios'),
                    'com_mdcmedia_liveplayer_ios' => $request->get('com_mdcmedia_liveplayer_ios'),
                    'com_ustv_player' => $request->get('com_ustv_player')
                ]
            ])->getBody()->getContents();
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
        $this->removeOldPromoNotification();

        Promotion::query()->delete();
        $promotion = new Promotion();
        $promotion->content = json_encode($request->except('_token'));
        $promotion->notification_id = $notificationIds ?? "[]";
        $promotion->save();
        return back();
    }

    public function stopPromo(Request $request)
    {
        DB::connection('mysql_tool_connection')->transaction(function () {
            Config::where([['id_application', 'com.liveplayer.android'], ['name', 'message_web'], ['device', 3]])
                ->orWhere([['id_application', 'com.mdc.iptvplayer.ios'], ['name', 'message'], ['device', 0]])
                ->orWhere([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'message']])
                ->orWhere([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_background']])
                ->orWhere([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'promo_text']])
                ->orWhere([['id_application', 'com.ustv.player'], ['name', 'message_web'], ['device', 0]])
                ->update(['value' => '']);
            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'enable_promo']])
                ->update(['value' => 0]);
        }, 5);
        $this->removeOldPromoNotification();
        Promotion::query()->delete();

        if (file_exists($this->promoConfigFile) && ($fp = file_get_contents($this->promoConfigFile)) !== false) {
            $promoConfig = json_decode($fp, true);
            $promoConfig["promotion"] = false;
            file_put_contents("$this->promoConfigFile", json_encode($promoConfig, JSON_PRETTY_PRINT));
        }

        if (file_exists($this->ustvUpgradeGreetImg . "upgrade_greet.jpg")) {
            rename($this->ustvUpgradeGreetImg . "upgrade_greet.jpg", $this->ustvUpgradeGreetImg . "upgrade_greet_" . date('Y_m_d') . ".jpg");
        }

        return back();
    }

    function removeOldPromoNotification()
    {
        // xóa notification cũ
        $oldNotificationIds = Promotion::select('notification_id')->pluck("notification_id");
        $oldNotificationIds->transform(function ($item, $key) {
            return json_decode($item);
        });

        if (!empty($oldNotificationIds->flatten()->toArray())) {
            try {
                // xóa notification cũ
                $result = $this->notificationRequest->request('POST', 'http://visearch.net/adminPromo/delete_notification.php', [
                    'form_params' => [
                        'notification_ids' => json_encode($oldNotificationIds->flatten())
                    ]
                ])->getBody()->getContents();
            } catch (\Exception $exception) {
                error_log($exception->getMessage());
            }
        }
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
