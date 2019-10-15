<?php

namespace App\Http\Controllers\web;

use App\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users;

class StreamController extends Controller
{
    //
    public function index(){
        $songs = Song::paginate(30);
//        $songs = Song::all();
//        foreach ($song as $song){
//            $song->Owner=$song->Users->value('Nickname');
//        }
        return view('layouts.lsp.stream',['songs' => $songs]);
    }

    public function show($songId){
        $song = Song::find($songId);
        return view('layouts.lsp.song_detail', ['song'=> $song]);
    }
}
