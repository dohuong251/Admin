<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;
use App\Models\Lsp\Songs;
use DateTime;
use DateTimeZone;
use DB;
use Exception;
use Illuminate\Http\Request;
use Memcache;

class RealtimeAnalyticController extends Controller
{
    //
    public function index()
    {
        return view('lsp.analytic_realtime');
    }

    public function filter(Request $request)
    {
        $data = Songs::select(['SongId', 'Name', 'Code'])
            ->where('LastOnline', '>=', DB::raw('curdate()'))
            ->get();
        $data_channels = array();
        foreach ($data as $item) {
            $data_channels[$item->SongId] = array(
                'Name' => $item->Name,
                'Code' => $item->Code
            );
        }

        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) or die('Could not conect to Memcache server');

        $listkeys = $this->getMemcacheKeysV2('localhost', 11211);

        $dataStreams = $this->getDatastream($memcache, $listkeys);

        $channels = array();
        foreach ($dataStreams as $key => $value) {
            $code = $value['Code'];
            $name = 'Channel Name';
            if (array_key_exists($key, $data_channels)) {
                $name = $data_channels[$key]['Name'];
            }

            $channels[] = array(
                'StreamId' => $key,
                'Code' => $code,
                'Name' => $name,
                'PLAYING' => $value['PLAYING'],
                'BUFFERING' => $value['BUFFERING'],
                'CONNECTING' => $value['CONNECTING'],
                'IOS' => $value['IOS'],
                'Android' => $value['Android']
            );
        }

        $memcache->close();
        $sort = $request->get('sort', 'PLAYING');
        $sortType = strtolower($request->get('order', 'desc'));
        $channels = $this->array_sort($channels, $sort, $sortType == 'desc' ? SORT_DESC : SORT_ASC);
        $count_total = count($listkeys);
        return array(
            "channels" => collect()->merge($channels),
            "totalViews" => $count_total,
            "sort" => array(
                "name" => $sort,
                "type" => $sortType
            )
        );
    }

    public function getRealTimeActiveUser()
    {
        $memcache = new Memcache;
        $memcache->connect('localhost', $port = 11211, 5);
        try {
            $activeUser = $memcache->get('active_users');
            if (!$activeUser && !is_array($activeUser)) $activeUser = $memcache->get('active_user');
        } catch (\Exception $exception) {
            \Log::debug($exception);
        }
        if (gettype($activeUser) == "string") {
            $activeUser = json_decode($activeUser, true);
        }
        if (gettype($activeUser) != "array") $activeUser = [];
        $memcache->close();
        $serverTimeZone = new DateTimeZone(timezone_name_from_abbr(exec('date +%Z')));
        $clientTimeZone = new DateTimeZone(date_default_timezone_get());
        $clientTimeFormat = "Y-m-d H:i:s";
        return array_map(function ($count) use ($clientTimeFormat, $clientTimeZone, $serverTimeZone) {
            $count['time'] = new DateTime($count['time'], $serverTimeZone);
            $count['time']->setTimeZone($clientTimeZone);
            return array(
                'x' => $count['time']->format($clientTimeFormat),
                'y' => $count['total']
            );
        }, $activeUser);
    }

    function getMemcacheKeysV2($server, $port, $limit = 10000)
    {
        $keysFound = array();
        $memcache = new Memcache;
        $memcache->connect($server, $port = 11211, 5);

        $slabs = $memcache->getExtendedStats('slabs');
        foreach ($slabs as $serverSlabs) {
            foreach ($serverSlabs as $slabId => $slabMeta) {
                try {
                    $cacheDump = $memcache->getExtendedStats('cachedump', (int)$slabId, 1000);
                } catch (Exception $e) {
                    continue;
                }

                if (!is_array($cacheDump)) {
                    continue;
                }

                foreach ($cacheDump as $dump) {

                    if (!is_array($dump)) {
                        continue;
                    }

                    foreach ($dump as $key => $value) {
                        $keysFound[] = $key;

                        if (count($keysFound) == $limit) {
                            return $keysFound;
                        }
                    }
                }
            }
        }
        $memcache->close();

        return $keysFound;
    }

    function getDatastream($memcache, $keys)
    {
        $dataStream = array();

        foreach ($keys as $key) {
            try {
                if ($memcache->get($key)) {
                    $item = $memcache->get($key);
                    if (gettype($item) == "string") {
                        $item = json_decode($item, true);
                    }
                    if (isset($item['Type']) && $item['Type'] == "PlayerState") {
                        if (array_key_exists($item['StreamId'], $dataStream)) {
                            if (strcmp($item['ApplicationId'], "com.mdcmedia.liveplayer.ios") == 0) {
                                $dataStream[$item['StreamId']]['IOS']++;
                            } else {
                                $dataStream[$item['StreamId']]['Android']++;
                            }
                            if ($item['State'] == 'PLAYING') {
                                $dataStream[$item['StreamId']]['PLAYING']++;
                            }
                            if ($item['State'] == 'BUFFERING') {
                                $dataStream[$item['StreamId']]['BUFFERING']++;
                            }
                            if ($item['State'] == 'CONNECTING') {
                                $dataStream[$item['StreamId']]['CONNECTING']++;
                            }
                        } else {
                            $playing = $buffering = $connecting = 0;
                            if ($item['State'] == 'PLAYING') {
                                $playing = 1;
                            } else if ($item['State'] == 'BUFFERING') {
                                $buffering = 1;
                            } else  $connecting = 1;
                            $dataStream[$item['StreamId']] = array(
                                'Code' => $item['StreamCode'],
                                'PLAYING' => $playing,
                                'BUFFERING' => $buffering,
                                'CONNECTING' => $connecting,
                                'IOS' => 0,
                                'Android' => 0
                            );
                        }
                    }

                }
            } catch (\Exception $exception) {
                \Log::debug($exception);
            }
        }
        return $dataStream;
    }

    public function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
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
