<?php

namespace App\Http\Controllers\Tool;

use App\Console\Commands\CheckParseUrl;
use App\Http\Controllers\Controller;
use App\Models\ReportRule;
use App\Models\Tool\Config;
use Artisan;
use Illuminate\Http\Request;

class TestRuleController extends Controller
{
    //
    public function index()
    {
        $config = Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])->get('value');
//        dd($config, $config->first()->value);
        return view('tools.test_rule', [
            'defaultConfig' => $config->first()->value ?? ""
        ]);
    }

    public function decryptUrl(Request $request)
    {
        $request->validate([
            "url" => "required",
            "rules" => "required|json"
        ]);

        $client = new \GuzzleHttp\Client();

        try {
            return $client->request('POST', env("PARSE_RULE_NODEJS_SERVER_URL"), [
                'json' => [
                    'url' => $request->get('url'),
                    'rules' => $request->get('rules'),
                ]
            ])->getBody()->getContents();
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    function updateRule(Request $request)
    {
        $request->validate([
            'rule' => 'required|json',
        ]);
        $rule = json_decode($request->get("rule"), true);

//        $originRule = json_decode(Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])->first()->value ?? null, true);
//        if ($originRule) {
//            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])
//                ->update(['value' => json_encode(array_replace_recursive($originRule, $rule))]);
//        } else {
//            Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])
//                ->update(['value' => $request->get("rule")]);
//        }

        Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])
            ->update(['value' => $request->get("rule")]);

//        $originAndroidRule = [];
//        if (env("PARSE_RULE_ANDROID_FILE_PATH") && file_exists(env("PARSE_RULE_ANDROID_FILE_PATH"))) {
//            $originAndroidRule = json_decode(base64_decode(file_get_contents(env("PARSE_RULE_ANDROID_FILE_PATH"))), true);
//        }
//        $ruleFile = fopen(env("PARSE_RULE_ANDROID_FILE_PATH"), "w");
//        fwrite($ruleFile, base64_encode(json_encode(array_replace_recursive($originAndroidRule, $rule))));
//        fclose($ruleFile);


        $ruleFile = fopen(env("PARSE_RULE_ANDROID_FILE_PATH"), "w");
        fwrite($ruleFile, base64_encode(json_encode($rule)));
        fclose($ruleFile);

        return response()->json([
            "result" => 1,
        ]);
    }

    public function getReportRuleLogs(Request $request)
    {
        $request->validate([
            "id" => "required|exists:report_rule",
        ]);

        $report = ReportRule::find($request->get("id"));
        return response()->json([
            "result" => 1,
            "logs" => is_array($report->log) ? array_values($report->log) : [],
            "name" => $report->name,
        ]);
    }

    public function checkParseRuleServiceState(Request $request)
    {
        return response()->json([
            "result" => 1,
            "running" => CheckParseUrl::isTaskRunning(),
        ]);
    }

    public function startCheckRule(Request $request)
    {
        Artisan::call("check:rules", []);
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return null;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return null;
    }
}
