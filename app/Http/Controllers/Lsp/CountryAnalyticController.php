<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;
use App\Models\Lsp\CountryStatistic;
use App\Models\Lsp\Songs;
use App\Models\Lsp\Users;
use Config;
use DB;
use Illuminate\Http\Request;
use PDO;

class CountryAnalyticController extends Controller
{

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
        'ZWE'=>'Zimbabwe',
        'OTH'=>"Other Country"
        );
    protected $iso_cpm = array(
        "GBR"=>2,
        "USA"=>1
    );

    public function index(Request $request)
    {
        if ($request->get('streamId') != null) {
            $stream = Songs::find($request->get('streamId'));
        }
        return view('lsp.analytic_country', [
            'stream' => $stream ?? null,
            'countries'=>$this->iso_array
        ]);
    }

    public function countryForUser(Request $request,$userId){
        $user = Users::where('UserId',$userId)->first();
        return view('lsp.analytic_country_user',[
            'userName' =>  $user ? $user->Nickname:"",
            'countries'=>$this->iso_array
        ]);
    }

    public function isoToName($iso){
        if(isset($this->iso_array[$iso]))
            return $this->iso_array[$iso];
        return "No Country";
    }

    public function isoToCPM($iso){
        if(isset($this->iso_cpm[$iso]))
            return $this->iso_cpm[$iso];
        return 0.2;
    }

    public function addDayView($currentView,$dayView){
        if($currentView){}
        else $currentView = array();

        if($currentView && $dayView){
            foreach ($dayView as $iso => $viewCount){
                if(isset($currentView[$iso]))
                    $currentView[$iso] = $currentView[$iso] + $viewCount;
                else $currentView[$iso] = $viewCount;
            }
        }
        return $currentView;
    }
    public function getStreamInfo($streamId,$startTime,$endTime,$country){
        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $viewsByDay = array();
        $countryStatistic = CountryStatistic::with(['song', 'song.users'])->where('SongId',$streamId)->first();
        $song = Songs::find($streamId);
        $maxView = 0;
        $minView = 0;
        $totalViewByCountry = array();
        $successView = 0;
        $debug = array();
        $topCountries = array();
        $topUser = $countryStatistic->song->users;
        $topUser['Streams'] = Songs::where('UserId',$topUser['UserId'])->count();

        if($countryStatistic && $song){
            foreach ($countryStatistic->DayStatistic ?? [] as $day => $views){
                if($views != NULL){
                    $currentDate = strtotime($day);
                    if ($currentDate >= $startTime && $currentDate <= $endTime) {
                        $copyViews = array();
                        foreach ($views ?? [] as $isoCode => $numView){
                            if($country && $country === $isoCode){

                            }else if($country) continue;
                            if(isset($totalViewByCountry[$isoCode])){
                                $totalViewByCountry[$isoCode] = $totalViewByCountry[$isoCode] + $numView;
                            }else $totalViewByCountry[$isoCode] = $numView;
                            $isoCode = $this->isoToName($isoCode);
                            $copyViews[$isoCode] = $numView;
                            if($numView > $maxView) $maxView = $numView;
                            if($numView < $minView) $minView = $numView;
                            $successView = $successView + $numView;
                        }
                        arsort( $copyViews);
                        $viewsByDay[$day] = $copyViews;
                    }
                }
            }
            // kiểm tra lastupdate có nằm trong khoảng thời gian cần lấy về
            if($countryStatistic->LastUpdate && $countryStatistic->LastDayStatistic){
                $currentDate = strtotime($countryStatistic->LastUpdate);
                if ($currentDate >= $startTime && $currentDate <= $endTime) {
                    $copyLastDayStatistic = array();
                    foreach ($countryStatistic->LastDayStatistic ?? [] as $isoCode => $numView){
                        if($country && $country === $isoCode){

                        }else if($country) continue;
                        if(isset($totalViewByCountry[$isoCode])){
                            $totalViewByCountry[$isoCode] = $totalViewByCountry[$isoCode] + $numView;
                        }else $totalViewByCountry[$isoCode] = $numView;
                        $isoCode = $this->isoToName($isoCode);
                        $copyLastDayStatistic[$isoCode] = $numView;
                        if($numView > $maxView) $maxView = $numView;
                        if($numView < $minView) $minView = $numView;
                        $successView = $successView + $numView;
                    }
                    arsort($copyLastDayStatistic);
                    $viewsByDay[$countryStatistic->LastUpdate] = $copyLastDayStatistic;
                }
            }
        }
        else {
            return response("Stream Or Statistic Not Found!",500);
        }

        $topUser['successViews'] = $successView;

        // Lấy 2 đất nước top đầu và gom các nước còn lại và 1 (OTH = Other)
        $sortViewsByDay = array();
        $allCountry = array();
        foreach ($viewsByDay as $day => $views){
            if(count($views)>4){
                $newViews = array();
                $oth = 0;
                $count = 0;
                foreach ($views as $iso => $numViews){
                    if($count < 2){
                        if(!in_array($iso,$allCountry))
                            $allCountry[] = $iso;
                        $newViews[$iso] = $numViews;
                    }else $oth = $oth + $numViews;
                    $count ++;
                }
                $newViews['OTH'] = $oth;
                if(!in_array('OTH',$allCountry))
                    $allCountry[] = 'OTH';
                $sortViewsByDay[$day] = $newViews;
            }else {
                foreach ($views as $iso => $numViews){
                    if(!in_array($iso,$allCountry))
                        $allCountry[] = $iso;
                }
                $sortViewsByDay[$day] = $views;
            }
        }
        $viewsByDay = $sortViewsByDay;

        // thêm những giá trị = 0 nếu như ngày đó không có
        $fullViewsByDay = array();
        foreach ($viewsByDay as $day => $views){
            $newViews = array();
            foreach($allCountry as $country)
                if(!isset($views[$country])){
                    $newViews[$country] = 0;
                }
            $fullViewsByDay[$day] = array_merge($views,$newViews);
        }
        $viewsByDay = $fullViewsByDay;

        // sort totalViewByCountry
        arsort($totalViewByCountry);

        // danh sách country
        foreach ($totalViewByCountry as $iso => $numViews){
            $topCountries[] = array(
                "iso"=>$iso,
                "successViews"=>$numViews,
                "Country"=>$this->isoToName($iso),
                "Amount"=>($this->isoToCPM($iso) * $numViews)
            );
        }

        // tạo CountryDes
        $CountryDes = "";
        foreach ($totalViewByCountry as $isoKey => $numView){
            $CountryDes = $CountryDes . $isoKey . ": " . $numView . "\n";
        }

        return [
            "allCountry"=>$allCountry,
            "viewByDays"=>$viewsByDay,
            "topStreams"=>array(array(
                "SongId"=>$streamId,
                "TotalViewByCountry"=>$totalViewByCountry,
                "Code" => $countryStatistic->song->Code ?? "",
                "Name" => $countryStatistic->song->Name ?? "",
                "Owner" => $countryStatistic->song->users->Nickname ?? "",
                "successViews"=>$successView,
                "CountryDes"=>$CountryDes
            )),
            "user" => $countryStatistic->song->users ?? null,
            "debug"=>$debug,
            "topCountries"=>$topCountries,
            "topUsers"=>array($topUser)
        ];
    }

    public function getStreamsInfo($startTime,$endTime,$country){
        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $viewsByDay = array();
        $countryStatistics = CountryStatistic::with(['song', 'song.users'])->orderBy("TotalView",'desc')->get();
        $debug = array();
        $allCountry = array();
        $topUsers = array();
        $topStreams = array();
        $userTotalViewByCountry = array();
        $userSuccessView = 0;
        $topCountries = array();

        if($countryStatistics){
            foreach ($countryStatistics as $countryStatistic){
                $streamId = $countryStatistic['SongId'];
                $totalViewByCountry = array();
                $successView = 0;
                foreach ($countryStatistic->DayStatistic ?? [] as $day => $views){
                    if($views != NULL){
                        $currentDate = strtotime($day);
                        if ($currentDate >= $startTime && $currentDate <= $endTime) {
                            $copyViews = array();
                            foreach ($views ?? [] as $isoCode => $numView){
                                if($country && $country === $isoCode){

                                }else if($country) continue;
                                if(isset($totalViewByCountry[$isoCode])){
                                    $totalViewByCountry[$isoCode] = $totalViewByCountry[$isoCode] + $numView;
                                }else $totalViewByCountry[$isoCode] = $numView;
                                $isoCode = $this->isoToName($isoCode);
                                $copyViews[$isoCode] = $numView;
                                $successView = $successView + $numView;
                            }
                            if(isset($viewsByDay[$day]))
                                $copyViews = $this->addDayView($viewsByDay[$day],$copyViews);
                            arsort( $copyViews);
                            $viewsByDay[$day] = $copyViews;
                        }
                    }
                }
                // kiểm tra lastupdate có nằm trong khoảng thời gian cần lấy về
                if($countryStatistic->LastUpdate && $countryStatistic->LastDayStatistic){
                    $currentDate = strtotime($countryStatistic->LastUpdate);
                    if ($currentDate >= $startTime && $currentDate <= $endTime) {
                        $copyLastDayStatistic = array();
                        foreach ($countryStatistic->LastDayStatistic ?? [] as $isoCode => $numView){
                            if($country && $country === $isoCode){

                            }else if($country) continue;
                            if(isset($totalViewByCountry[$isoCode])){
                                $totalViewByCountry[$isoCode] = $totalViewByCountry[$isoCode] + $numView;
                            }else $totalViewByCountry[$isoCode] = $numView;
                            $isoCode = $this->isoToName($isoCode);
                            $copyLastDayStatistic[$isoCode] = $numView;

                            $successView = $successView + $numView;
                        }
                        if(isset($viewsByDay[$countryStatistic->LastUpdate]))
                            $copyLastDayStatistic = $this->addDayView($viewsByDay[$countryStatistic->LastUpdate],$copyLastDayStatistic);
                        arsort($copyLastDayStatistic);
                        $viewsByDay[$countryStatistic->LastUpdate] = $copyLastDayStatistic;
                    }
                }

                // sort totalViewByCountry
                arsort($totalViewByCountry);
                // lưu totalViewByCountry vào userTotalVieByCountry
                foreach ($totalViewByCountry as $isoCode => $numView){
                    if(isset($userTotalViewByCountry[$isoCode])){
                        $userTotalViewByCountry[$isoCode] = $userTotalViewByCountry[$isoCode] + $numView;
                    }else $userTotalViewByCountry[$isoCode] = $numView;
                }

                // tạo CountryDes
                $CountryDes = "";
                foreach ($totalViewByCountry as $isoKey => $numView){
                    $CountryDes = $CountryDes . $isoKey . ": " . $numView . "\n";
                }

                $topStreams[] = array(
                    "SongId"=>$streamId,
                    "TotalViewByCountry"=>$totalViewByCountry,
                    "Code" => $countryStatistic->song->Code ?? "",
                    "Name" => $countryStatistic->song->Name ?? "",
                    "Owner" => $countryStatistic->song->users->Nickname ?? "",
                    "successViews"=>$successView,
                    "CountryDes"=>$CountryDes
                );

                $user = $countryStatistic->song->users;
                if($user){
                    if(isset($topUsers["UserId".$user['UserId']])){
                        $topUsers["UserId".$user['UserId']]['successViews'] = $topUsers["UserId".$user['UserId']]['successViews'] + $successView;
                    }else{
                        $user['successViews'] = $successView;
                        $user['Streams'] = Songs::where('UserId',$user['UserId'])->count();
                        $topUsers["UserId".$user['UserId']] = $user;
                    }
                }


                // lưu userSuccessView
                $userSuccessView = $userSuccessView + $successView;

            }
            // sort totalViewByCountry
            arsort($userTotalViewByCountry);

            // danh sách country
            foreach ($userTotalViewByCountry as $iso => $numViews){
                $topCountries[] = array(
                    "iso"=>$iso,
                    "successViews"=>$numViews,
                    "Country"=>$this->isoToName($iso),
                    "Amount"=>$this->isoToCPM($iso) * $numViews
                );
            }

            // tạo CountryDes
            $userCountryDes = "";
            $userCountryDesShort = "";
            $userCountryDesCount = 0;
            foreach ($userTotalViewByCountry as $isoKey => $numView){
                $userCountryDes = $userCountryDes . $isoKey . ": " . $numView . "\n";
                if($userCountryDesCount < 5)
                    $userCountryDesShort = $userCountryDesShort . $isoKey . ": " . $numView . "\n";
                $userCountryDesCount ++;
            }
        }
        else {
            return response("Stream Or Statistic Not Found!",500);
        }

        // Lấy 2 đất nước top đầu và gom các nước còn lại và0 1 (OTH = Other)
        $sortViewsByDay = array();
        foreach ($viewsByDay as $day => $views){
            if(count($views)>4){
                $newViews = array();
                $oth = 0;
                $count = 0;
                foreach ($views as $iso => $numViews){
                    if($count < 2){
                        if(!in_array($iso,$allCountry))
                            $allCountry[] = $iso;
                        $newViews[$iso] = $numViews;
                    }else $oth = $oth + $numViews;
                    $count ++;
                }
                $newViews['OTH'] = $oth;
                if(!in_array('OTH',$allCountry))
                    $allCountry[] = 'OTH';
                $sortViewsByDay[$day] = $newViews;
            }else {
                foreach ($views as $iso => $numViews){
                    if(!in_array($iso,$allCountry))
                        $allCountry[] = $iso;
                }
                $sortViewsByDay[$day] = $views;
            }
        }
        $viewsByDay = $sortViewsByDay;

        // thêm những giá trị = 0 nếu như ngày đó không có
        $fullViewsByDay = array();
        foreach ($viewsByDay as $day => $views){
            $newViews = array();
            foreach($allCountry as $country)
                if(!isset($views[$country])){
                    $newViews[$country] = 0;
                }
            $fullViewsByDay[$day] = array_merge($views,$newViews);
        }
        $viewsByDay = $fullViewsByDay;

        // sắp xếp stream theo successViews giảm dần
        usort($topStreams, function ($a, $b) {
            return $a['successViews'] <= $b['successViews'];
        });
        $topStreams = array_slice($topStreams,0,100);

        // sort $topUsers
        usort($topUsers, function ($a, $b) {
            return $a['successViews'] <= $b['successViews'];
        });
        $topUsers = array_slice($topUsers,0,100);

        return [
            "allCountry"=>$allCountry,
            "viewByDays"=>$viewsByDay,
            "topStreams"=>$topStreams,
            "user" => $countryStatistic->song->users ?? null,
            "debug"=>$debug,
            "topUsers"=>array_values($topUsers),
            "topCountries"=>$topCountries,
        ];
    }

    public function getUserInfo($userId,$startTime,$endTime,$country){
        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $viewsByDay = array();
        $streamIds = Songs::where('UserId',$userId)->pluck('SongId')->toArray();
        $countryStatistics = CountryStatistic::with(['song', 'song.users'])->whereIn('SongId',$streamIds)->get();
        $debug = array();
        $allCountry = array();
        $topUsers = array();
        $topStreams = array();
        $userTotalViewByCountry = array();
        $userSuccessView = 0;
        $topCountries = array();

        if($countryStatistics){
            $topUser = $countryStatistics[0]->song->users;
            $topUser['Streams'] = count($streamIds);
            foreach ($countryStatistics as $countryStatistic){
                $streamId = $countryStatistic['SongId'];
                $totalViewByCountry = array();
                $successView = 0;
                foreach ($countryStatistic->DayStatistic ?? [] as $day => $views){
                    if($views != NULL){
                        $currentDate = strtotime($day);
                        if ($currentDate >= $startTime && $currentDate <= $endTime) {
                            $copyViews = array();
                            foreach ($views ?? [] as $isoCode => $numView){
                                if($country && $country === $isoCode){

                                }else if($country) continue;
                                if(isset($totalViewByCountry[$isoCode])){
                                    $totalViewByCountry[$isoCode] = $totalViewByCountry[$isoCode] + $numView;
                                }else $totalViewByCountry[$isoCode] = $numView;
                                $isoCode = $this->isoToName($isoCode);
                                $copyViews[$isoCode] = $numView;
                                $successView = $successView + $numView;
                            }
                            if(isset($viewsByDay[$day]))
                                $copyViews = $this->addDayView($viewsByDay[$day],$copyViews);
                            arsort( $copyViews);
                            $viewsByDay[$day] = $copyViews;
                        }
                    }
                }
                // kiểm tra lastupdate có nằm trong khoảng thời gian cần lấy về
                if($countryStatistic->LastUpdate && $countryStatistic->LastDayStatistic){
                    $currentDate = strtotime($countryStatistic->LastUpdate);
                    if ($currentDate >= $startTime && $currentDate <= $endTime) {
                        $copyLastDayStatistic = array();
                        foreach ($countryStatistic->LastDayStatistic ?? [] as $isoCode => $numView){
                            if($country && $country === $isoCode){

                            }else if($country) continue;
                            if(isset($totalViewByCountry[$isoCode])){
                                $totalViewByCountry[$isoCode] = $totalViewByCountry[$isoCode] + $numView;
                            }else $totalViewByCountry[$isoCode] = $numView;
                            $isoCode = $this->isoToName($isoCode);
                            $copyLastDayStatistic[$isoCode] = $numView;

                            $successView = $successView + $numView;
                        }
                        if(isset($viewsByDay[$countryStatistic->LastUpdate]))
                            $copyLastDayStatistic = $this->addDayView($viewsByDay[$countryStatistic->LastUpdate],$copyLastDayStatistic);
                        arsort($copyLastDayStatistic);
                        $viewsByDay[$countryStatistic->LastUpdate] = $copyLastDayStatistic;
                    }
                }

                // sort totalViewByCountry
                arsort($totalViewByCountry);
                // lưu totalViewByCountry vào userTotalVieByCountry
                foreach ($totalViewByCountry as $isoCode => $numView){
                    if(isset($userTotalViewByCountry[$isoCode])){
                        $userTotalViewByCountry[$isoCode] = $userTotalViewByCountry[$isoCode] + $numView;
                    }else $userTotalViewByCountry[$isoCode] = $numView;
                }

                // tạo CountryDes
                $CountryDes = "";
                foreach ($totalViewByCountry as $isoKey => $numView){
                    $CountryDes = $CountryDes . $isoKey . ": " . $numView . "\n";
                }

                $topStreams[] = array(
                    "SongId"=>$streamId,
                    "TotalViewByCountry"=>$totalViewByCountry,
                    "Code" => $countryStatistic->song->Code ?? "",
                    "Name" => $countryStatistic->song->Name ?? "",
                    "Owner" => $countryStatistic->song->users->Nickname ?? "",
                    "successViews"=>$successView,
                    "CountryDes"=>$CountryDes
                );

                // lưu userSuccessView
                $userSuccessView = $userSuccessView + $successView;

            }
            $topUser['successViews'] = $userSuccessView;
            // sort totalViewByCountry
            arsort($userTotalViewByCountry);

            // danh sách country
            foreach ($userTotalViewByCountry as $iso => $numViews){
                $topCountries[] = array(
                    "iso"=>$iso,
                    "successViews"=>$numViews,
                    "Country"=>$this->isoToName($iso),
                    "Amount"=>$this->isoToCPM($iso) * $numViews
                );
            }

            // tạo CountryDes
            $userCountryDes = "";
            $userCountryDesShort = "";
            $userCountryDesCount = 0;
            foreach ($userTotalViewByCountry as $isoKey => $numView){
                $userCountryDes = $userCountryDes . $isoKey . ": " . $numView . "\n";
                if($userCountryDesCount < 5)
                    $userCountryDesShort = $userCountryDesShort . $isoKey . ": " . $numView . "\n";
                $userCountryDesCount ++;
            }
            $topUser['CountryDes'] = $userCountryDes;
            $topUser['CountryDesShort'] = $userCountryDesShort;
            $topUsers[] = $topUser;
        }
        else {
            return response("Stream Or Statistic Not Found!",500);
        }

        // Lấy 2 đất nước top đầu và gom các nước còn lại và0 1 (OTH = Other)
        $sortViewsByDay = array();
        foreach ($viewsByDay as $day => $views){
            if(count($views)>4){
                $newViews = array();
                $oth = 0;
                $count = 0;
                foreach ($views as $iso => $numViews){
                    if($count < 2){
                        if(!in_array($iso,$allCountry))
                            $allCountry[] = $iso;
                        $newViews[$iso] = $numViews;
                    }else $oth = $oth + $numViews;
                    $count ++;
                }
                $newViews['OTH'] = $oth;
                if(!in_array('OTH',$allCountry))
                    $allCountry[] = 'OTH';
                $sortViewsByDay[$day] = $newViews;
            }else {
                foreach ($views as $iso => $numViews){
                    if(!in_array($iso,$allCountry))
                        $allCountry[] = $iso;
                }
                $sortViewsByDay[$day] = $views;
            }
        }
        $viewsByDay = $sortViewsByDay;

        // thêm những giá trị = 0 nếu như ngày đó không có
        $fullViewsByDay = array();
        foreach ($viewsByDay as $day => $views){
            $newViews = array();
            foreach($allCountry as $country)
                if(!isset($views[$country])){
                    $newViews[$country] = 0;
                }
            $fullViewsByDay[$day] = array_merge($views,$newViews);
        }
        $viewsByDay = $fullViewsByDay;

        // sắp xếp stream theo successViews giảm dần
        usort($topStreams, function ($a, $b) {
            return $a['successViews'] <= $b['successViews'];
        });

        return [
            "allCountry"=>$allCountry,
            "viewByDays"=>$viewsByDay,
            "topStreams"=>$topStreams,
            "user" => $countryStatistic->song->users ?? null,
            "debug"=>$debug,
            "topUsers"=>$topUsers,
            "topCountries"=>$topCountries
        ];
    }

    public function filter(Request $request)
    {
        DB::disableQueryLog();
        DB::connection('mysql_lsp_connection')->getPdo()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        $startTime = $request->get('start', "1970-01-01");
        $endTime = $request->get('end', date_format(now(), "Y-m-d"));
        $userId = $request->get('userId');
        $streamId = $request->get('streamId');

        // 1: user
        // 2: stream
        // 3: country
        $viewMode = $request->get('viewMode');
        $country = $request->get('country');

        /**
         * thông tin về view của 1 stream cụ thể
         */
        if ($streamId) {
            return $this->getStreamInfo($streamId,$startTime,$endTime,$country);
        }

        /**
         * thông tin về view của 1 user cụ thể
         */
        if ($userId) {
            return $this->getUserInfo($userId,$startTime,$endTime,$country);
        }


        /**
         * thông tin chung lọc theo ngày
         */

        return $this->getStreamsInfo($startTime,$endTime,$country);
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
