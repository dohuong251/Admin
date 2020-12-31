<?php

namespace App\Http\Controllers\Lsp;

use App\Models\Lsp\CountryStatistic;
use Config;
use DB;
use PDO;
use App\Models\Lsp\Songs;
use App\Models\Lsp\Users;
use App\Models\Lsp\Views;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryAnalyticController extends Controller
{
    //

protected $iso_array = array(
        'ABW'=>'Aruba',
        'AFG'=>'Afghanistan',
        'AGO'=>'Angola',
        'AIA'=>'Anguilla',
        'ALA'=>'Åland Islands',
        'ALB'=>'Albania',
        'AND'=>'Andorra',
        'ARE'=>'United Arab Emirates',
        'ARG'=>'Argentina',
        'ARM'=>'Armenia',
        'ASM'=>'American Samoa',
        'ATA'=>'Antarctica',
        'ATF'=>'French Southern Territories',
        'ATG'=>'Antigua and Barbuda',
        'AUS'=>'Australia',
        'AUT'=>'Austria',
        'AZE'=>'Azerbaijan',
        'BDI'=>'Burundi',
        'BEL'=>'Belgium',
        'BEN'=>'Benin',
        'BES'=>'Bonaire, Sint Eustatius and Saba',
        'BFA'=>'Burkina Faso',
        'BGD'=>'Bangladesh',
        'BGR'=>'Bulgaria',
        'BHR'=>'Bahrain',
        'BHS'=>'Bahamas',
        'BIH'=>'Bosnia and Herzegovina',
        'BLM'=>'Saint Barthélemy',
        'BLR'=>'Belarus',
        'BLZ'=>'Belize',
        'BMU'=>'Bermuda',
        'BOL'=>'Bolivia, Plurinational State of',
        'BRA'=>'Brazil',
        'BRB'=>'Barbados',
        'BRN'=>'Brunei Darussalam',
        'BTN'=>'Bhutan',
        'BVT'=>'Bouvet Island',
        'BWA'=>'Botswana',
        'CAF'=>'Central African Republic',
        'CAN'=>'Canada',
        'CCK'=>'Cocos (Keeling) Islands',
        'CHE'=>'Switzerland',
        'CHL'=>'Chile',
        'CHN'=>'China',
        'CIV'=>'Côte d\'Ivoire',
        'CMR'=>'Cameroon',
        'COD'=>'Congo, the Democratic Republic of the',
        'COG'=>'Congo',
        'COK'=>'Cook Islands',
        'COL'=>'Colombia',
        'COM'=>'Comoros',
        'CPV'=>'Cape Verde',
        'CRI'=>'Costa Rica',
        'CUB'=>'Cuba',
        'CUW'=>'Curaçao',
        'CXR'=>'Christmas Island',
        'CYM'=>'Cayman Islands',
        'CYP'=>'Cyprus',
        'CZE'=>'Czech Republic',
        'DEU'=>'Germany',
        'DJI'=>'Djibouti',
        'DMA'=>'Dominica',
        'DNK'=>'Denmark',
        'DOM'=>'Dominican Republic',
        'DZA'=>'Algeria',
        'ECU'=>'Ecuador',
        'EGY'=>'Egypt',
        'ERI'=>'Eritrea',
        'ESH'=>'Western Sahara',
        'ESP'=>'Spain',
        'EST'=>'Estonia',
        'ETH'=>'Ethiopia',
        'FIN'=>'Finland',
        'FJI'=>'Fiji',
        'FLK'=>'Falkland Islands (Malvinas)',
        'FRA'=>'France',
        'FRO'=>'Faroe Islands',
        'FSM'=>'Micronesia, Federated States of',
        'GAB'=>'Gabon',
        'GBR'=>'United Kingdom',
        'GEO'=>'Georgia',
        'GGY'=>'Guernsey',
        'GHA'=>'Ghana',
        'GIB'=>'Gibraltar',
        'GIN'=>'Guinea',
        'GLP'=>'Guadeloupe',
        'GMB'=>'Gambia',
        'GNB'=>'Guinea-Bissau',
        'GNQ'=>'Equatorial Guinea',
        'GRC'=>'Greece',
        'GRD'=>'Grenada',
        'GRL'=>'Greenland',
        'GTM'=>'Guatemala',
        'GUF'=>'French Guiana',
        'GUM'=>'Guam',
        'GUY'=>'Guyana',
        'HKG'=>'Hong Kong',
        'HMD'=>'Heard Island and McDonald Islands',
        'HND'=>'Honduras',
        'HRV'=>'Croatia',
        'HTI'=>'Haiti',
        'HUN'=>'Hungary',
        'IDN'=>'Indonesia',
        'IMN'=>'Isle of Man',
        'IND'=>'India',
        'IOT'=>'British Indian Ocean Territory',
        'IRL'=>'Ireland',
        'IRN'=>'Iran, Islamic Republic of',
        'IRQ'=>'Iraq',
        'ISL'=>'Iceland',
        'ISR'=>'Israel',
        'ITA'=>'Italy',
        'JAM'=>'Jamaica',
        'JEY'=>'Jersey',
        'JOR'=>'Jordan',
        'JPN'=>'Japan',
        'KAZ'=>'Kazakhstan',
        'KEN'=>'Kenya',
        'KGZ'=>'Kyrgyzstan',
        'KHM'=>'Cambodia',
        'KIR'=>'Kiribati',
        'KNA'=>'Saint Kitts and Nevis',
        'KOR'=>'Korea, Republic of',
        'KWT'=>'Kuwait',
        'LAO'=>'Lao People\'s Democratic Republic',
        'LBN'=>'Lebanon',
        'LBR'=>'Liberia',
        'LBY'=>'Libya',
        'LCA'=>'Saint Lucia',
        'LIE'=>'Liechtenstein',
        'LKA'=>'Sri Lanka',
        'LSO'=>'Lesotho',
        'LTU'=>'Lithuania',
        'LUX'=>'Luxembourg',
        'LVA'=>'Latvia',
        'MAC'=>'Macao',
        'MAF'=>'Saint Martin (French part)',
        'MAR'=>'Morocco',
        'MCO'=>'Monaco',
        'MDA'=>'Moldova, Republic of',
        'MDG'=>'Madagascar',
        'MDV'=>'Maldives',
        'MEX'=>'Mexico',
        'MHL'=>'Marshall Islands',
        'MKD'=>'Macedonia, the former Yugoslav Republic of',
        'MLI'=>'Mali',
        'MLT'=>'Malta',
        'MMR'=>'Myanmar',
        'MNE'=>'Montenegro',
        'MNG'=>'Mongolia',
        'MNP'=>'Northern Mariana Islands',
        'MOZ'=>'Mozambique',
        'MRT'=>'Mauritania',
        'MSR'=>'Montserrat',
        'MTQ'=>'Martinique',
        'MUS'=>'Mauritius',
        'MWI'=>'Malawi',
        'MYS'=>'Malaysia',
        'MYT'=>'Mayotte',
        'NAM'=>'Namibia',
        'NCL'=>'New Caledonia',
        'NER'=>'Niger',
        'NFK'=>'Norfolk Island',
        'NGA'=>'Nigeria',
        'NIC'=>'Nicaragua',
        'NIU'=>'Niue',
        'NLD'=>'Netherlands',
        'NOR'=>'Norway',
        'NPL'=>'Nepal',
        'NRU'=>'Nauru',
        'NZL'=>'New Zealand',
        'OMN'=>'Oman',
        'PAK'=>'Pakistan',
        'PAN'=>'Panama',
        'PCN'=>'Pitcairn',
        'PER'=>'Peru',
        'PHL'=>'Philippines',
        'PLW'=>'Palau',
        'PNG'=>'Papua New Guinea',
        'POL'=>'Poland',
        'PRI'=>'Puerto Rico',
        'PRK'=>'Korea, Democratic People\'s Republic of',
        'PRT'=>'Portugal',
        'PRY'=>'Paraguay',
        'PSE'=>'Palestinian Territory, Occupied',
        'PYF'=>'French Polynesia',
        'QAT'=>'Qatar',
        'REU'=>'Réunion',
        'ROU'=>'Romania',
        'RUS'=>'Russian Federation',
        'RWA'=>'Rwanda',
        'SAU'=>'Saudi Arabia',
        'SDN'=>'Sudan',
        'SEN'=>'Senegal',
        'SGP'=>'Singapore',
        'SGS'=>'South Georgia and the South Sandwich Islands',
        'SHN'=>'Saint Helena, Ascension and Tristan da Cunha',
        'SJM'=>'Svalbard and Jan Mayen',
        'SLB'=>'Solomon Islands',
        'SLE'=>'Sierra Leone',
        'SLV'=>'El Salvador',
        'SMR'=>'San Marino',
        'SOM'=>'Somalia',
        'SPM'=>'Saint Pierre and Miquelon',
        'SRB'=>'Serbia',
        'SSD'=>'South Sudan',
        'STP'=>'Sao Tome and Principe',
        'SUR'=>'Suriname',
        'SVK'=>'Slovakia',
        'SVN'=>'Slovenia',
        'SWE'=>'Sweden',
        'SWZ'=>'Swaziland',
        'SXM'=>'Sint Maarten (Dutch part)',
        'SYC'=>'Seychelles',
        'SYR'=>'Syrian Arab Republic',
        'TCA'=>'Turks and Caicos Islands',
        'TCD'=>'Chad',
        'TGO'=>'Togo',
        'THA'=>'Thailand',
        'TJK'=>'Tajikistan',
        'TKL'=>'Tokelau',
        'TKM'=>'Turkmenistan',
        'TLS'=>'Timor-Leste',
        'TON'=>'Tonga',
        'TTO'=>'Trinidad and Tobago',
        'TUN'=>'Tunisia',
        'TUR'=>'Turkey',
        'TUV'=>'Tuvalu',
        'TWN'=>'Taiwan, Province of China',
        'TZA'=>'Tanzania, United Republic of',
        'UGA'=>'Uganda',
        'UKR'=>'Ukraine',
        'UMI'=>'United States Minor Outlying Islands',
        'URY'=>'Uruguay',
        'USA'=>'United States',
        'UZB'=>'Uzbekistan',
        'VAT'=>'Holy See (Vatican City State)',
        'VCT'=>'Saint Vincent and the Grenadines',
        'VEN'=>'Venezuela, Bolivarian Republic of',
        'VGB'=>'Virgin Islands, British',
        'VIR'=>'Virgin Islands, U.S.',
        'VNM'=>'Viet Nam',
        'VUT'=>'Vanuatu',
        'WLF'=>'Wallis and Futuna',
        'WSM'=>'Samoa',
        'YEM'=>'Yemen',
        'ZAF'=>'South Africa',
        'ZMB'=>'Zambia',
        'ZWE'=>'Zimbabwe'
        );


    public function index(Request $request)
    {
        if ($request->get('streamId') != null) {
            $stream = Songs::find($request->get('streamId'));
        }
        return view('lsp.analytic_country', [
            'stream' => $stream ?? null
        ]);
    }

    public function filter(Request $request)
    {
        DB::disableQueryLog();
        DB::connection('mysql_lsp_connection')->getPdo()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        $startTime = $request->get('start', "1970-01-01");
        $endTime = $request->get('end', date_format(now(), "Y-m-d"));
        $userId = $request->get('userId');
        $streamId = $request->get('streamId');

        $topStreams = array();
        $topUsers = array();
        /**
         * thông tin về view của 1 stream cụ thể
         */
        if ($streamId) {
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $viewsByDay = array();
            $countryStatistic = CountryStatistic::with(['song', 'song.users'])->where('SongId',$streamId)->first();
            $song = Songs::find($streamId);
            $maxView = 0;
            $minView = 0;
            $totalView = array();

            if($countryStatistic && $song){
                foreach ($countryStatistic->DayStatistic ?? [] as $day => $views){
                    $currentDate = strtotime($day);
                    if ($currentDate >= $startTime && $currentDate <= $endTime) {
                        foreach ($views ?? [] as $isoCode => $numView){
                            if(isset($totalView[$isoCode])){
                                $totalView[$isoCode] = $totalView[$isoCode] + $numView;
                            }else $totalView[$isoCode] = $numView;
                            if($numView > $maxView) $maxView = $numView;
                            if($numView < $minView) $minView = $numView;
                        }
                        $viewsByDay[$day] = $views;
                    }
                }
                // kiểm tra lastupdate có nằm trong khoảng thời gian cần lấy về
                if($countryStatistic->LastUpdate && $countryStatistic->LastDayStatistic){
                    $currentDate = strtotime($countryStatistic->LastUpdate);
                    if ($currentDate >= $startTime && $currentDate <= $endTime) {
                        foreach ($countryStatistic->LastDayStatistic ?? [] as $isoCode => $numView){
                            if($numView > $maxView) $maxView = $numView;
                            if($numView < $minView) $minView = $numView;
                            if(isset($totalView[$isoCode])){
                                $totalView[$isoCode] = $totalView[$isoCode] + $numView;
                            }else $totalView[$isoCode] = $numView;
                        }
                        $viewsByDay[$countryStatistic->LastUpdate] = $countryStatistic->LastDayStatistic;
                    }
                }
            }else {
                return response("Stream Or Statistic Not Found!",500);
            }
            return [
              "viewByDays"=>$viewsByDay,
              "topStreams"=>array(array(
                  "SongId"=>$streamId,
                  "TotalView"=>$totalView,
                  "Code" => $countryStatistic->song->Code ?? "",
                  "Name" => $countryStatistic->song->Name ?? "",
                  "Owner" => $countryStatistic->song->users->Nickname ?? "",
              )),
              "user" => $countryStatistic->song->users ?? null,
            ];
        }

        /**
         * thông tin về view của 1 user cụ thể
         */
        if ($userId) {

        }


        /**
         * thông tin chung lọc theo ngày
         */
        $startTime = $request->get('start', date_format(now(), "Y-m-d"));
        $endTime = $request->get('end', date_format(now(), "Y-m-d"));

        $streamViewsChunk = Views::with(['song' => function ($query) {
            $query->select(['SongId', 'Code', 'Name', 'UserId']);
        }, 'song.users' => function ($query) {
            $query->select(['UserId', 'Nickname']);
        }])->where('last_update', '>=', $startTime)->where(function ($query) {
            $query->whereNotNull('days_view')
                ->orWhere('success_count', '>', 0);
        });


        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $viewsByDay = array();
        $TOP_RECORD_LIMIT = 10;
        $streamViewsChunk->chunk(5000, function ($streamViews) use (&$topUsers, &$TOP_RECORD_LIMIT, &$viewsByDay, &$endTime, &$startTime, &$topStreams) {
            foreach ($streamViews as $streamView) {
                $totalStreamView = 0;
                $totalStreamPlaybackDuration = 0;
                $totalStreamBufferDuration = 0;
                foreach (json_decode($streamView->days_view) ?? [] as $key => $view) {
                    $currentDate = strtotime($key);
                    if ($currentDate >= $startTime && $currentDate <= $endTime) {
                        if (!array_key_exists($key, $viewsByDay)) {
                            $viewsByDay[$key] = array(
                                "successCount" => 0,
                                "failCount" => 0
                            );
                        }

                        // đếm số lượng view của 1 stream cụ thể trong khoảng thời gian từ startTime đến endTime
                        $totalStreamView += $view->success;
                        $totalStreamPlaybackDuration += $view->playback_duration ?? 0;
                        $totalStreamBufferDuration += $view->buffer_duration ?? 0;

                        // đếm số lượng view success và fail trong khoảng thời gian từ startTime đến endTime
                        $viewsByDay[$key]["successCount"] += $view->success;
                        $viewsByDay[$key]["failCount"] += $view->fail;
                    }
                }

                $lastUpdate = strtotime($streamView->last_update);
                if ($lastUpdate >= $startTime && $lastUpdate <= $endTime) {
                    if (!array_key_exists($streamView->last_update, $viewsByDay)) {
                        $viewsByDay[$streamView->last_update] = array(
                            "successCount" => 0,
                            "failCount" => 0
                        );
                    }
                    $totalStreamView += $streamView->success_count;
                    $totalStreamPlaybackDuration += $streamView->playback_duration ?? 0;
                    $totalStreamBufferDuration += $streamView->buffer_duration ?? 0;

                    $viewsByDay[$streamView->last_update]["successCount"] += $streamView->success_count;
                    $viewsByDay[$streamView->last_update]["failCount"] += $streamView->fail_count;
                }

                if ($totalStreamView > 0) {
                    array_push($topStreams, array(
                        "SongId" => $streamView->SongId,
                        "successViews" => $totalStreamView,
                        "PlaybackDuration" => $totalStreamPlaybackDuration,
                        "BufferDuration" => $totalStreamBufferDuration,
                        "StreamView" => $streamView,
//                    "StreamUrl" => $streamView->song->SongId ?? null ? route('admin.lsp.streams.show', $streamView->song->SongId) : null,
//                    "Code" => $streamView->song->Code ?? "",
//                    "Name" => $streamView->song->Name ?? "",
//                    "Owner" => $streamView->song->users->Nickname ?? "",
//                    "OwnerUrl" => $streamView->song->users->UserId ?? null ? route('admin.lsp.user.show', $streamView->song->users->UserId) : null,
                    ));

                    usort($topStreams, function ($a, $b) {
                        return $a['successViews'] <= $b['successViews'];
                    });
                    $topStreams = array_slice($topStreams, 0, $TOP_RECORD_LIMIT);

                    if ($streamView->song && $streamView->song->users) {
                        $currentUserId = $streamView->song->users->UserId;
                    } else {
                        $currentUserId = -1;
                    }

                    if ($currentUserId != -1) {
                        if (array_key_exists($currentUserId, $topUsers)) {
                            $topUsers[$currentUserId]["successViews"] += $totalStreamView;
                            $topUsers[$currentUserId]["PlaybackDuration"] += $totalStreamPlaybackDuration;
                            $topUsers[$currentUserId]["BufferDuration"] += $totalStreamBufferDuration;
                            $topUsers[$currentUserId]["Streams"]++;

                        } else {
                            $topUsers[$currentUserId] = array(
                                "UserId" => $currentUserId,
                                "StreamView" => $streamView,
//                        "Nickname" => $streamView->song->users->Nickname ?? "",
                                "successViews" => $totalStreamView,
                                "Streams" => 1,
                                "PlaybackDuration" => $totalStreamPlaybackDuration,
                                "BufferDuration" => $totalStreamBufferDuration,
                            );
                        }
                    }
                }
            }
        });
        // sắp xếp theo successViews giảm dần
        usort($topUsers, function ($a, $b) {
            return $a['successViews'] <= $b['successViews'];
        });
        $topUsers = array_slice($topUsers, 0, $TOP_RECORD_LIMIT);

        // thêm các trường trước khi gửi về client
        foreach ($topUsers as &$topUser) {
            $streamView = $topUser["StreamView"];
            $topUser["Nickname"] = $streamView->song->users->Nickname ?? "";
            unset($topUser["StreamView"]);
        }

        foreach ($topStreams as &$topStream) {
            $streamView = $topStream["StreamView"];
            $topStream["Code"] = $streamView->song->Code ?? "";
            $topStream["Name"] = $streamView->song->Name ?? "";
            $topStream["Owner"] = $streamView->song->users->Nickname ?? "";
            unset($topStream["StreamView"]);
        }

        // sắp xếp theo thời gian
        uksort($viewsByDay, function ($a, $b) {
            return strtotime($a) <= strtotime($b);
        });

        return array(
            "viewByDays" => $viewsByDay,
            "topStreams" => $topStreams,
            "topUsers" => $topUsers,
        );
    }

    public function search(Request $request)
    {
        $record_per_request = Config::get("constant.AJAX_SELECT_SEARCH_RECORD_PER_PAGE");
        $query = $request->get('query');
        if ($request->get('type', 1) == 1) {
            //search stream
            if ($request->has('userId')) {
                $results = Songs::where([['UserId', $request->get('userId')], ['Name', 'like', "%$query%"]])->select(['Name as text', 'SongId as id'])->orderBy('ViewByAll', 'desc')->paginate($record_per_request);
            } else {
                $results = Songs::where('Name', 'like', "%$query%")->select(['Name as text', 'SongId as id'])->orderBy('ViewByAll', 'desc')->paginate($record_per_request);
            }
            return array(
                "results" => $results->items(),
                "pagination" => array(
                    "more" => $results->hasMorePages()
                )
            );
        } else {
            // search user
            if ((int)$request->get('query')) {
                $results = Users::where('Nickname', 'like', "%$query%")
                    ->orWhere('users.UserId', $request->get('query'))
                    ->leftJoin('songs', 'users.UserId', '=', 'songs.UserId')
                    ->select(['Nickname as text', 'users.UserId as id'])
                    ->groupBy('users.UserId')
                    ->orderByRaw('sum(songs.ViewByAll) desc')
                    ->limit($record_per_request)
                    ->offset(($request->get('page', 1) - 1) * $record_per_request)
                    ->get();
            } else {
                $results = Users::where('Nickname', 'like', "%$query%")
                    ->leftJoin('songs', 'users.UserId', '=', 'songs.UserId')
                    ->select(['Nickname as text', 'users.UserId as id'])
                    ->groupBy('users.UserId')
                    ->orderByRaw('sum(songs.ViewByAll) desc')
                    ->limit($record_per_request)
                    ->offset(($request->get('page', 1) - 1) * $record_per_request)
                    ->get();
            }
            return array(
                "results" => $results,
                "pagination" => array(
                    "more" => $results->count() == $record_per_request ? true : false
                )
            );
        }
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
