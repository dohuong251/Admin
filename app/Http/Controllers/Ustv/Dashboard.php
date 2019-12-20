<?php

namespace App\Http\Controllers\Ustv;

use App\Models\Ustv\Channel;
use App\Models\Ustv\View;
use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        return view('ustv.dashboard');
    }

    public function searchChannel(Request $request)
    {
        $record_per_request = Config::get("constant.AJAX_SELECT_SEARCH_RECORD_PER_PAGE");
        $query = $request->get('query');

        if ((int)$query) {
            $results = Channel::where('id', $query)->select(['symbol as text', 'id']);
        } else {
            $results = Channel::where('symbol', 'like', "%$query%")->select(['symbol as text', 'id']);
        }
        $results = $results->where("id_channel_type", 1)
            ->whereIn('id_type_tv', [9, 12])
            ->orderBy('watch_counter', 'desc')
            ->paginate($record_per_request)
            ->appends(Request()->except('page'));
        return array(
            "results" => $results->items(),
            "pagination" => array(
                "more" => $results->hasMorePages()
            )
        );

    }

    public function filter(Request $request)
    {
        $startTime = $request->get('start', "1970-01-01");
        $endTime = $request->get('end', date_format(now(), "Y-m-d"));
        $channelId = $request->get('channelId');

        $topStreams = array();
        /**
         * thông tin về view của 1 stream cụ thể
         */
        if ($channelId) {
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $viewsByDay = array();
            $totalStreamView = 0;
            $totalStreamPlaybackDuration = 0;
            $totalStreamBufferDuration = 0;

            $streamViews = View::with(['channel'])
                ->join('channels', 'channels.id', '=', 'views.ChannelId')->where(function ($query) {
                    $query->where("id_channel_type", 1)
                        ->whereIn('id_type_tv', [9, 12]);
                })
                ->where('ChannelId', $channelId)
                ->whereRaw("DATE(last_update) > $startTime")
                ->get();
            if (!$streamViews) return response("Channel Not Found!", 500);
            foreach ($streamViews as $streamView) {
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
            }

            // sắp xếp theo thời gian
            uksort($viewsByDay, function ($a, $b) {
                return strtotime($a) <= strtotime($b);
            });

            return array(
                "viewByDays" => $viewsByDay,
                "topStreams" => array(array(
                    "id" => $channelId,
                    "successViews" => $totalStreamView,
                    "PlaybackDuration" => $totalStreamPlaybackDuration,
                    "BufferDuration" => $totalStreamBufferDuration,
                    "symbol" => $streamView->channel->symbol ?? "",
                ))
            );
        }

        /**
         * thông tin chung lọc theo ngày
         */
        $startTime = $request->get('start', date_format(now(), "Y-m-d"));
        $endTime = $request->get('end', date_format(now(), "Y-m-d"));

        $streamViewsChunk = View::with('channel')
            ->join('channels', 'channels.id', '=', 'views.ChannelId')
            ->where(function ($query) {
                $query->where("id_channel_type", 1)
                    ->whereIn('id_type_tv', [9, 12]);
            })
            ->where(function ($query) {
                $query->whereNotNull('days_view')
                    ->orWhere('success_count', '>', 0);
            })
            ->whereRaw("DATE(last_update) > $startTime");

        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $viewsByDay = array();
        $TOP_RECORD_LIMIT = 10;
        $streamViewsChunk->chunk(5000, function ($streamViews) use (&$TOP_RECORD_LIMIT, &$viewsByDay, &$endTime, &$startTime, &$topStreams) {
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
                    if (array_key_exists("$streamView->ChannelId", $topStreams)) {
                        $topStreams["$streamView->ChannelId"]["successViews"] += $totalStreamView;
                    } else {
                        $topStreams["$streamView->ChannelId"] = array(
                            "id" => $streamView->ChannelId,
                            "successViews" => $totalStreamView,
                            "PlaybackDuration" => $totalStreamPlaybackDuration,
                            "BufferDuration" => $totalStreamBufferDuration,
                            "symbol" => $streamView->channel->symbol ?? "",
                        );
                    }
                }
            }
        });

        // sắp xếp theo thời gian
        uksort($viewsByDay, function ($a, $b) {
            return strtotime($a) <= strtotime($b);
        });

        usort($topStreams, function ($a, $b) {
            return $a['successViews'] <= $b['successViews'];
        });
        $topStreams = array_slice($topStreams, 0, $TOP_RECORD_LIMIT);

        return array(
            "viewByDays" => $viewsByDay,
            "topStreams" => $topStreams,
        );
    }

    //

    /**
     * @inheritDoc
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
    }

    /**
     * @inheritDoc
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
    }
}
