<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\mảng;
use App\Models\Lsp\Songs;
use App\Models\Lsp\Users;
use Config;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use View;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'Views');
        $order = $request->get('order', 'desc');
        $query = $request->get('query');
        $order = strtolower($order);
        $record_per_page = Config::get('constant.PAGINATION_RECORD_PER_PAGE');

//        $users = Users::withCount(['songs as Views' => function ($query) {
//            $query->select(DB::raw("SUM(ViewByAll)"));
//        }])
//            ->withCount(['songs as Streams'])
//            ->orderBy($sort, $order)
//            ->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'));

//        $users = Users::withCount(['songs as Views' => function ($query) {
//            $query->select(DB::raw("SUM(ViewByAll)"));
//        }])
//            ->withCount(['songs as Streams'])
//            ->orderBy($sort, $order)->limit(0,50);


//        $users = Songs::selectRaw('count(*) as Streams')->orderBy("Streams", 'desc')->groupBy('UserId')->with('users')->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'));
//        dd($users);
//
//        $users = Songs::with('users')->selectRaw('sum(ViewByAll) as Views')->orderBy("Views", 'desc')->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'));
//        $users = Songs::groupBy('UserId')->sum('ViewByAll')->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'));
//        dd(Users::with('songs')->first());
//        dd(Songs::with('users')->first());
//        dd($users);

        $totalStreamUsers = Songs::where('UserId', '>', 0)->distinct('UserId')->count('UserId');
        $totalNonStreamUsers = Users::count() - $totalStreamUsers;


        $streamUsers = collect();
        $nonStreamUsers = collect();
        if ($query) {
            $users = Users::where('Nickname', 'like', '%' . $query . '%')
                ->orWhere('Email', 'like', '%' . $query . '%')
                ->orWhere('FacebookId', 'like', '%' . $query . '%')
                ->withCount(['songs as Views' => function ($query) {
                    $query->selectRaw("SUM(ViewByAll)");
                }])
                ->withCount(['songs as Streams'])
                ->orderBy($sort, $order)
                ->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'));
        } else {
            /**
             * sắp xếp giảm dần: [user có stream, user không có stream]
             * sắp xếp tăng dần: [user không có stream, user có stream]
             */
            if ($order == "desc") {
                $remain_stream_user = $totalStreamUsers - ($page - 1) * $record_per_page;
                if ($remain_stream_user > 0) {
                    $songs = Songs::with('users')
                        ->has('users')
                        ->selectRaw('UserId, sum(ViewByAll) as Views, count(*) as Streams')
                        ->where('UserId', '>', 0)
                        ->groupBy('UserId')
                        ->orderBy($sort, $order)
                        ->limit($record_per_page)
                        ->offset(($page - 1) * $record_per_page)
                        ->get();
//            $streamUsers = $songs->flatten()->pluck('users');
                    $streamUsers = (object)$songs->map(function ($item) {
                        return (object)array_merge([
                            'Views' => $item->Views,
                            'Streams' => $item->Streams
                        ], $item->users->toArray());
                    });
                }
                if ($streamUsers->count() < 50) {
                    // đã duyệt hết số lượng user có stream
                    if ($streamUsers->count() == 0) {
                        $nonStreamUsers = Users::select('users.*')
                            ->whereNotIn('UserId', Songs::distinct('UserId')->select('UserId'))
                            ->limit($record_per_page)
                            ->offset(($page - ceil($totalStreamUsers / $record_per_page) - 1) * $record_per_page + ($record_per_page - $totalStreamUsers % $record_per_page))
                            ->orderBy('UserId', $order)
                            ->get();
                    } else {
                        $nonStreamUsers = Users::select('users.*')
                            ->whereNotIn('UserId', Songs::distinct('UserId')->select('UserId'))
                            ->limit($record_per_page - ($streamUsers->count()))
                            ->offset(0)
                            ->orderBy('UserId', $order)
                            ->get();
                    }
                }
            } else {
                $remain_none_stream_user = $totalNonStreamUsers - ($page - 1) * $record_per_page;
                if ($remain_none_stream_user > 0) {
                    $nonStreamUsers = Users::select('users.*')
                        ->whereNotIn('UserId', Songs::distinct('UserId')->select('UserId'))
                        ->limit($record_per_page)
                        ->offset(($page - 1) * $record_per_page)
                        ->orderBy('UserId', $order)
                        ->get();
                }
                if ($nonStreamUsers->count() < 50) {
                    // đã duyệt hết số lượng user có stream
                    if ($nonStreamUsers->count() == 0) {
                        $songs = Songs::with('users')
                            ->selectRaw('UserId, sum(ViewByAll) as Views, count(*) as Streams')
                            ->where('UserId', '>', 0)
                            ->groupBy('UserId')
                            ->orderBy($sort, $order)
                            ->limit($record_per_page)
                            ->offset(($page - ceil($totalNonStreamUsers / $record_per_page) - 1) * $record_per_page + ($record_per_page - $totalNonStreamUsers % $record_per_page))
                            ->get();
                    } else {
                        $songs = Songs::with('users')
                            ->selectRaw('UserId, sum(ViewByAll) as Views, count(*) as Streams')
                            ->where('UserId', '>', 0)
                            ->groupBy('UserId')
                            ->orderBy($sort, $order)
                            ->limit($record_per_page - ($nonStreamUsers->count()))
                            ->offset(0)
                            ->get();
                    }
                    $streamUsers = (object)$songs->map(function ($item) {
                        return (object)array_merge([
                            'Views' => $item->Views,
                            'Streams' => $item->Streams
                        ], $item->users->toArray());
                    });
                }
            }
            if ($order == "desc") $users = new LengthAwarePaginator($streamUsers->concat($nonStreamUsers), Users::count(), $record_per_page, $page, ['path' => route('admin.lsp.user.index', ['sort' => $sort, 'order' => $order])]);
            else $users = new LengthAwarePaginator($nonStreamUsers->concat($streamUsers), Users::count(), $record_per_page, $page, ['path' => route('admin.lsp.user.index', ['sort' => $sort, 'order' => $order])]);
//        $users = new LengthAwarePaginator($streamUsers, $totalStreamUsers, $record_per_page, $page, ['path' => route('admin.lsp.user.index')]);
        }
        return view('lsp.users', [
            'users' => $users,
            'sort' => $sort,
            'order' => $order
        ]);
    }

    public function show($userId)
    {
        $user = Users::find($userId);
        return view('lsp.user_detail', [
            'user' => $user,
            "deleteUrlDetailPage" => route('admin.lsp.streams.delete'),
            "recordNameDetailPage" => "Streams"
        ]);
    }

    public function streams($userId)
    {
        return DataTables::eloquent(Songs::query()->where('UserId', $userId))
            ->addColumn('manage_url', function (Songs $song) {
                return route('admin.lsp.streams.show', $song->SongId);
            })
            ->toJson();
    }

    public function destroy($userId)
    {
        if (Users::destroy($userId)) {
            return redirect()->route('admin.lsp.user.index');
        } else return abort(500);
    }


    public function update(Request $request, $id)
    {
        $updateUser = Users::find($id);
        if (!$updateUser) return redirect()->back();
        $validateRules = [
            'Email' => ['nullable', 'email', Rule::unique('mysql_lsp_connection.users')->ignore($updateUser)],
            'Nickname' => 'required'
        ];
        $validateMess = [
            'Nickname.required' => 'Please enter your nickname',
            'Email.email' => 'Email không đúng định dạng',
            'Email.unique' => 'Email đã tồn tại',
        ];
        $request->validate($validateRules, $validateMess);

        $updateUser->Nickname = $request->get('Nickname', $updateUser->Nickname);
        $updateUser->Email = $request->get('Email', $updateUser->Email);
        $updateUser->Fullname = $request->get('Fullname', $updateUser->Fullname);
        $updateUser->Birthday = $request->get('Birthday', $updateUser->Birthday);
        $updateUser->Phone = $request->get('Phone', $updateUser->Phone);
        $updateUser->Role = $request->get('Role', $updateUser->Role);
        $updateUser->Status = $request->get('Status', $updateUser->Status);
        $updateUser->Type = $request->get('Type', $updateUser->Type);

        if (!is_null($request->get('Password'))) {
            $updateUser->Password = md5($request->get('Password'));
        }

        $updateUser->save();
        return redirect()->back();
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteMethod() method.
        return Users::class;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return array(
            "deleteUrl" => route('admin.lsp.user.delete'),
            "recordName" => "Thành Viên",
        );
    }
}
