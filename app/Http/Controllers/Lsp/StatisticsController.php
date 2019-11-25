<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;
use App\Models\Lsp\Songs;
use App\Models\Lsp\Users;
use App\Models\Lsp\Views;
use Cache;
use DB;
use Illuminate\Http\Request;
use PDO;
use function foo\func;

class StatisticsController extends Controller
{
    //
    public function index()
    {
//        dd(Songs::find(412832)->Code);
        return view('lsp.analytic_statistics');
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
            $totalStreamView = 0;
            $totalStreamPlaybackDuration = 0;
            $totalStreamBufferDuration = 0;

            $streamView = Views::with(['song', 'song.users'])->find($streamId);
            if (!$streamView) return abort(500);
            foreach (json_decode($streamView->days_view) as $key => $view) {
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
            // sắp xếp theo thời gian
            uksort($viewsByDay, function ($a, $b) {
                return strtotime($a) <= strtotime($b);
            });

            return array(
                "viewByDays" => $viewsByDay,
                "topStreams" => array(array(
                    "SongId" => $streamId,
                    "successViews" => $totalStreamView,
                    "PlaybackDuration" => $totalStreamPlaybackDuration,
                    "BufferDuration" => $totalStreamBufferDuration,
//                    "StreamUrl" => $streamView->song->SongId ?? null ? route('admin.lsp.streams.show', $streamView->song->SongId) : null,
                    "Code" => $streamView->song->Code ?? "",
                    "Name" => $streamView->song->Name ?? "",
                    "Owner" => $streamView->song->users->Nickname ?? "",
//                    "OwnerUrl" => $streamView->song->users->UserId ?? null ? route('admin.lsp.user.show', $streamView->song->users->UserId) : null,
                )),
                "user" => $streamView->song->users ?? null,
            );
        }

        /**
         * thông tin về view của 1 user cụ thể
         */
        if ($userId) {
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $viewsByDay = array();
            $user = Users::with(['songs' => function ($query) {
                $query->select(['SongId', 'Code', 'Name']);
            }, 'songs.view'])->find($userId);
            if (!$user) return abort(500);

            array_push($topUsers, $user->makeHidden(['songs', 'songs.view'])->toArray());
            $topUsers[0]["successViews"] = 0;
            $topUsers[0]["PlaybackDuration"] = 0;
            $topUsers[0]["BufferDuration"] = 0;

            foreach ($user->songs as $stream) {
                if (!$stream || !$stream->view || !$stream->view->days_view) continue;
                $streamView = $stream->view;
                $totalStreamView = 0;
                $totalStreamPlaybackDuration = 0;
                $totalStreamBufferDuration = 0;

                foreach (json_decode($streamView->days_view) as $key => $view) {
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
                        "SongId" => $stream->SongId,
                        "successViews" => $totalStreamView,
                        "PlaybackDuration" => $totalStreamPlaybackDuration,
                        "BufferDuration" => $totalStreamBufferDuration,
//                        "StreamUrl" => route('admin.lsp.streams.show', $stream->SongId),
                        "Code" => $stream->Code,
                        "Name" => $stream->Name,
                        "Owner" => $user->Nickname,
//                        "OwnerUrl" => route('admin.lsp.user.show', $user->UserId),
                    ));
                    $topUsers[0]["successViews"] += $totalStreamView;
                    $topUsers[0]["PlaybackDuration"] += $totalStreamPlaybackDuration;
                    $topUsers[0]["BufferDuration"] += $totalStreamBufferDuration;
                }
            }
            $topUsers[0]["Streams"] = count($topStreams);
            // sắp xếp stream theo successViews giảm dần
            usort($topStreams, function ($a, $b) {
                return $a['successViews'] <= $b['successViews'];
            });
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


        /**
         * thông tin chung lọc theo ngày
         */
        $startTime = $request->get('start', date_format(now(), "Y-m-d"));
        $endTime = $request->get('end', date_format(now(), "Y-m-d"));

        $streamViewsChunk = Views::with(['song' => function ($query) {
            $query->select(['SongId', 'Code', 'Name']);
        }, 'song.users' => function ($query) {
            $query->select(['UserId', 'Nickname']);
        }])->where('last_update', '>=', $startTime)->whereNotNull('days_view');

        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $viewsByDay = array();
        $TOP_RECORD_LIMIT = 10;
        $streamViewsChunk->chunk(5000, function ($streamViews) use (&$topUsers, &$TOP_RECORD_LIMIT, &$viewsByDay, &$endTime, &$startTime, &$topStreams) {
            dd(1);
            foreach ($streamViews as $streamView) {
                $totalStreamView = 0;
                $totalStreamPlaybackDuration = 0;
                $totalStreamBufferDuration = 0;
                foreach (json_decode($streamView->days_view) as $key => $view) {
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
        $record_per_request = 10;
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
