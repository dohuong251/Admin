<?php

namespace App\Console\Commands;

use App\Models\Lsp\Songs;
use App\Models\ReportRule;
use App\Models\Tool\Config;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckParseUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:rules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check live stream player parse rule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getMutexPath()
    {
        return storage_path('logs' . DIRECTORY_SEPARATOR . 'schedule-' . sha1($this->signature) . '.log');
    }

    public static function isTaskRunning()
    {
        return file_exists((new CheckParseUrl)->getMutexPath());
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    const MAX_LINK_CHECK = 10;

    public function handle()
    {
        if ($this->isTaskRunning()) {
            echo "prevent duplicate task running\n";
            return;
        }
        echo "task running\n";
        fopen($this->getMutexPath(), "w");
        try {
            $rules = data_get(json_decode(Config::where([['id_application', 'com.mdcmedia.liveplayer.ios'], ['device', 0], ['name', 'parser_rules']])->first()->value ?? null), "Rules", []);
            if (is_array($rules) && count($rules)) {

                $client = new \GuzzleHttp\Client();

                ReportRule::query()->delete();
                foreach ($rules as $rule) {
                    $matchSyntax = data_get($rule, "Match");

                    echo "checking $matchSyntax\n";
                    if ($matchSyntax) {
                        $links = Songs::where("URL", "like", "%$matchSyntax% parseUrl=1")->orderByDesc("LastOnline")
                            ->limit(self::MAX_LINK_CHECK)
                            ->get()
                            ->pluck("URL")
                            ->transform(function ($url) {
                                return Str::replaceLast(" parseUrl=1", "", $url);
                            });
                        $reportRuleParams = [];
                        foreach ($links as $link) {

                            $reportRuleParams = [
                                "name" => $matchSyntax,
                                "status" => 3,
                                "url" => $link,
                                "parse_url" => "",
                                "log" => [],
                            ];

                            try {
                                $parseLinkResponse = json_decode($client->request('POST', env("PARSE_RULE_NODEJS_SERVER_URL"), [
                                    'json' => [
                                        'url' => $link,
                                        'rules' => json_encode([
                                            "Rules" => [$rule]
                                        ]),
                                    ]
                                ])->getBody()->getContents());
                                $parseUrl = data_get($parseLinkResponse, "url");
                                if ($parseUrl) {
                                    $stepResults = data_get($parseLinkResponse, "stepResults", []);

                                    if (is_array($stepResults) && count($stepResults) > count(data_get($reportRuleParams, "log", []))) {
                                        $reportRuleParams = [
                                            "name" => $matchSyntax,
                                            "status" => 3,
                                            "url" => $link,
                                            "parse_url" => $parseUrl,
                                            "log" => $stepResults,
                                        ];
                                    }
                                    if (count(array_filter(explode(" engineOptions", $parseUrl))) < 2) {
                                        continue;
                                    }

                                    $hlsUrl = data_get(explode(" ", $parseUrl), 0);
                                    $engineOptions = explode("::", data_get(explode(" engineOptions=", $parseUrl), 1));
                                    $ffmpegOption = "";
                                    foreach ($engineOptions as $index => $engineOption) {
                                        if ($index % 2 === 0) {
                                            $value = $engineOptions[$index + 1];
                                            $ffmpegOption .= sprintf(' -%s "%s"', $engineOption, $value);
                                        }
                                    }
                                    $command = sprintf('ffprobe %s -i "%s"', $ffmpegOption, $hlsUrl);
                                    echo "command: $command\n";
                                    exec($command, $output, $code);
                                    if ($code === 0) {
                                        // success
                                        ReportRule::create([
                                            "name" => $matchSyntax,
                                            "status" => 1,
                                            "url" => $link,
                                            "parse_url" => $parseUrl,
                                            "log" => ($stepResults),
                                        ]);
                                    } else {

                                        // error
                                        ReportRule::create([
                                            "name" => $matchSyntax,
                                            "status" => 2,
                                            "url" => $link,
                                            "parse_url" => $parseUrl,
                                            "log" => ($stepResults),
                                        ]);
                                    }
                                    $reportRuleParams = [];
                                    break;
                                }
                            } catch (\Exception $exception) {
                                \Log::debug("check parse url error");
                                \Log::debug($exception);
                            } catch (GuzzleException $e) {
                                \Log::debug("check parse url request error");
                                \Log::debug($e);
                            }
                        }
                        if (count($reportRuleParams)) {
                            $reportRuleParams["log"] = ($reportRuleParams["log"]);
                            ReportRule::create($reportRuleParams);
                        }
                    }
                    echo "checked $matchSyntax\n";
                }
            }
        } catch (\Exception $exception) {

        }
        unlink($this->getMutexPath());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->handle();
        } catch (\Exception $exception) {
        }
        return 0;
    }
}
