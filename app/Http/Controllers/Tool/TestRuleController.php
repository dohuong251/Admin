<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Models\Tool\Config;
use Illuminate\Http\Request;
use Str;
use Validator;

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
//        $validator = Validator::make($request->all(), [
//            "url" => "required",
//            "rules" => "required|json"
//        ]);

//        $validator->after(function ($validator) {
//            if(!json_decode($validator->getData()["rules"])){
//                return $validator->errors()->add('rules', "Rules field in json rule invalid");
//            }
//            $rules = json_decode($validator->getData()["rules"])->Rules;
//            if (!$rules) {
//                return $validator->errors()->add('rules', "Rules field in json rule can't be empty");
//            } else if (!is_array($rules)) {
//                return $validator->errors()->add('rules', "Rules field in json rule must be array");
//            } else if (!count($rules) > 0) {
//                return $validator->errors()->add('rules', "Rules field in json rule can't be empty");
//            }
//        });

//        if ($validator->fails()) {
//            return response($validator->,422);
//        }

//        $resultPerStage = collect();

//        $Link = $request->get('url');
//        $rules = json_decode($request->get('rules'))->Rules;

        $client = new \GuzzleHttp\Client();

        try {
            return $client->request('POST', 'localhost:3000/parseUrl', [
                'form_params' => [
                    'url' => $request->get('url'),
                    'rules' => json_encode(array(
                        "Rules" => [json_decode($request->get('rules'), JSON_PRETTY_PRINT)]
                    )),
                ]
            ])->getBody()->getContents();
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }

//        $result = "testResult";
//        dd("\$a = \"" .($rules[0]->Stages[0]->Link) . "\";");
//        eval("\$a = \"" . str_replace("\$", "\\\$", str_replace("\"", "\\\"", str_replace("\\", "\\\\", $rules[0]->Stages[0]->Link))) . "\";");
//        dd($rules[0]->Stages[0]->Link, $a, "\$a = " . str_replace("$", "\$", $rules[0]->Stages[0]->Link) . ";", str_replace("$", "\$", $rules[0]->Stages[0]->Link));

//        foreach ($rules as $pageRule) {
//            if (Str::contains($Link, $pageRule->Match)) {
//                error_log($pageRule->Name);
//                foreach ($pageRule->Stages as $stage) {
//                    if (isset($goto) && $goto && $stage->Id != $goto) continue;
//                    $goto = false;
//                    error_log($stage->Id . " \t " . $stage->Action);
//                    switch ($stage->Action) {
//                        case "GOTO":
//                            eval("\$goto = " . $stage->Stage . ";");
//                            break;
//
//                        case "CONCAT":
//                            // duyệt mảng thay các chuỗi bắt đầu bằng giá trị biến
//                            forEach ($stage->Targets as $index => &$target) {
//                                if ($this->isVariableOnly($target)) {
//                                    eval("\$target = " . $target . ";");
//                                } else {
//                                    eval("\$target = \"" . $this->escapeString($target) . "\";");
//                                }
//                            }
//                            eval("\$stage->Result = \"" . $this->escapeString(join($stage->Targets)) . "\";");
//                            break;
//
//                        case "EVAL":
//                            eval("$stage->String = ");
//                            break;
//                    }
//                }
//            }
//        }
    }

//    function isVariableOnly($string)
//    {
//        return preg_match("/^\\$\\w+$/", $string);
//    }
//
//    function escapeString($string)
//    {
//        return str_replace("\$", "\\\$", str_replace("\"", "\\\"", str_replace("\\", "\\\\", $string)));
//    }

    function updateRule(Request $request)
    {
        $request->validate([
            'rule' => 'required|json',
        ]);
        return Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])
            ->update(['value' => $request->get('rule')]);
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
