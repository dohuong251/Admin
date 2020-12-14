<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;
use App\Models\Lsp\Complain;
use App\Models\Lsp\Copyrightstreams;
use App\Models\Lsp\Features;
use App\Models\Lsp\Messages;
use App\Models\Lsp\Songs;
use Carbon\Carbon;
use Config;
use DB;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = $request->get('query');
        $record_per_page = Config::get('constant.PAGINATION_RECORD_PER_PAGE');
        $songs = Songs::with('users')
            ->where('Name', 'like', '%' . $query . '%')
            ->orWhere('Code', 'like', '%' . $query . '%')
            ->orWhere('SongId', 'like', '%' . $query . '%')
            ->orWhere('URL', 'like', '%' . $query . '%')
            ->withCount('likes')
            ->orderBy('ViewByAll', 'desc')
            ->paginate($record_per_page)->appends(Request()->except('page'));
//        $songs = Songs::with('users')->orderBy('ViewByAll', 'desc')->paginate($record_per_page);
        return view('lsp.streams', ['songs' => $songs]);
    }

    public function reviewStreams(Request $request){
        $songIds = Copyrightstreams::pluck('SongId')->toArray();
        $query = $request->get('query');
        $record_per_page = Config::get('constant.PAGINATION_RECORD_PER_PAGE');
        $songs = Songs::with('users')
            ->join('copyrightstreams','copyrightstreams.SongId','=','songs.SongId')
            ->where('songs.Name', 'like', '%' . $query . '%')
            ->withCount('likes')
            ->orderBy('copyrightstreams.DeleteDate', 'desc')
            ->paginate($record_per_page)->appends(Request()->except('page'));
//        $songs = Songs::with('users')->orderBy('ViewByAll', 'desc')->paginate($record_per_page);
        return view('lsp.review-streams', ['songs' => $songs]);
    }

    public function show($songId)
    {
        $song = Songs::find($songId);
        return view('lsp.stream_detail', ['song' => $song]);
    }

    public function update(Request $request, $songId)
    {
        $validateRules = [
            'Name' => 'required',
            'URL' => 'required'
        ];
        $request->validate($validateRules);
        $updatedSong = Songs::find($songId);
        $updatedSong->Name = $request->get('Name', $updatedSong->Name);
        $updatedSong->CategoryId = $request->get('CategoryId', $updatedSong->CategoryId);
        $updatedSong->Privacy = $request->get('Privacy', $updatedSong->Privacy);
        $updatedSong->Copyright = $request->get('Copyright', $updatedSong->Copyright);
        $updatedSong->Description = $request->get('Description', $updatedSong->Description);
        $updatedSong->URL = $request->get('URL', $updatedSong->URL);
        $updatedSong->save();
        return back();
    }

    public function create()
    {
        return view('lsp.stream_create');
    }

    public function store(Request $request)
    {
//        Songs::where('Code', 0)->delete();
        $validateRules = [
            'Name' => 'required',
            'URL' => 'required'
        ];

        $request->validate($validateRules);

        $addStream = new Songs();
        $addStream->fill($request->except('_token'));
        $addStream->PublishedDate = Carbon::now();
        $addStream->LastOnline = Carbon::now();
        if ($addStream->save()) {
            return redirect()->route('admin.lsp.streams.show', $addStream->SongId);
        } else {
            return back()->withInput()->with('insertErr', 'Insert Stream Error');
        }
    }

    public function complain()
    {
        $record_per_page = Config::get('constant.PAGINATION_RECORD_PER_PAGE');
        $complainStreams = Complain::with('song')->selectRaw('*, count(*) as Num')->orderBy('Time', 'desc')->groupBy('ChannelCode')->paginate($record_per_page)->appends(Request()->except('page'));
        return view('lsp.stream_complain', ['complainStreams' => $complainStreams]);
    }

    public function suspendMessages(Request $request)
    {
        $streamCode = $request->get('code');
    }

    public function suspend(Request $request)
    {
        $validateRules = [
            'Reason' => 'required',
            'SongId' => 'required'
        ];
        $request->validate($validateRules);

        $suspendStream = Songs::find($request->get('SongId'));
        if ($suspendStream != null) {
            DB::connection('mysql_lsp_connection')->transaction(function () use ($request, $suspendStream) {
                $suspendStream->Copyright = 1;
                $suspendStream->save();
                if ($request->has('Message') && $request->get('Message')) {
                    $suspendMessage = new Messages();
                    $suspendMessage->FromUserId = 15;
                    $suspendMessage->Message = "NOTIFICATION\nYour stream '" . $suspendStream->Name . "' (Code:" . $suspendStream->Code . ") is suspended\nReason: " . $request->get("Reason") . "\nMessage: " . $request->get('Message');
                    $suspendMessage->Time = now();
                    $suspendMessage->ToUserId = $suspendStream->UserId;
                    $suspendMessage->save();
                }
                Complain::where('ChannelCode', $suspendStream->Code)->delete();
                DB::connection('mysql_lsp_connection')->table('copyrightstreams')->insert([
                    'SongId' => $suspendStream->SongId,
                    'Name' => $suspendStream->Name,
                    'Type' => $suspendStream->Type,
                    'ImageURL' => $suspendStream->ImageURL,
                    'UserId' => $suspendStream->UserId,
                    'Description' => $suspendStream->Description,
                    'URL' => $suspendStream->URL,
                    'LikeCount' => $suspendStream->LikeCount,
                    'PublishedDate' => $suspendStream->PublishedDate,
                    'LastOnline' => $suspendStream->LastOnline,
                    'Code' => $suspendStream->Code,
                    'ViewByAll' => $suspendStream->ViewByAll,
                    'Privacy' => $suspendStream->Privacy,
                    'ReferenceId' => $suspendStream->ReferenceId,
                    'available' => $suspendStream->available,
                    'order' => $suspendStream->order,
                    'Language' => $suspendStream->Language,
                    'OwnerId' => 15,
                    'DeleteDate' => Carbon::now(),
                    'Reason' => $request->get("Reason"),
                    'Comment' => $request->get('Message'),
                ]);

            }, 5);
        }
        return back();
    }

    public function destroy($songId)
    {
        $deleteSong = Songs::find($songId);
        if ($deleteSong == null) return view('errors.500', ['message' => 'Stream not found']);
        else {
            if ($deleteSong->delete()) {
                return redirect()->route('admin.lsp.streams');
            } else {
                return abort(500);
            }
        }
    }

    public function feature()
    {
        $record_per_page = Config::get('constant.PAGINATION_RECORD_PER_PAGE');
        $features = Features::has('songs')->withCount('likes')->paginate($record_per_page)->appends(Request()->except('page'));
//        dd($songs->flatten()->pluck('songs'));
//        dd($songs, $songs->first()->songs);
        return view('lsp.stream_feature', ['features' => $features]);
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return Songs::class;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return array(
            "deleteUrl" => route("admin.lsp.streams.delete"),
            "recordName" => "Stream",
        );
    }
}
