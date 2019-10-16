<?php

namespace App\Http\Controllers\web;

use App\Models\LSP\Songs;
use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StreamController extends Controller
{
    //
    public function index()
    {
        $record_per_page = Config::get('constant.PAGINATION_RECORD_PER_PAGE');
        $songs = Songs::paginate($record_per_page);
//        $songs = Song::all();
//        foreach ($song as $song){
//            $song->Owner=$song->Users->value('Nickname');
//        }
        return view('layouts.lsp.streams', ['songs' => $songs]);
    }

    public function show($songId)
    {
        $song = Songs::find($songId);
        return view('layouts.lsp.song_detail', ['song' => $song]);
    }

    public function filter(Request $request)
    {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        return array(
            "LastOnline" => Songs::whereBetween('LastOnline', [$startDate, $endDate])
                ->selectRaw('LastOnline as Date, count(*) as Total')
                ->groupBy('LastOnline')
                ->orderBy('LastOnline', 'asc')
                ->get(),
            "Published" => Songs::whereBetween('PublishedDate', [$startDate, $endDate])
                ->selectRaw('PublishedDate as Date, count(*) as Total')
                ->groupBy('PublishedDate')
                ->orderBy('PublishedDate', 'asc')
                ->get());
    }
}
