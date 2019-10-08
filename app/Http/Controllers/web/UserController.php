<?php

namespace App\Http\Controllers\web;

use App\Song;
use App\User;
use App\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     *
     */

    public function index(Request $request){

        $users = Users::paginate(30);

        //Thêm trường Views vào bảng users
        foreach ($users as $user){
            $user->Views=$user->Songs->sum("ViewByAll");
        }
        return view('layouts.livestreamplayer.user',['users'=>$users]);
    }

    public function show($userId){
        $user = Users::find($userId);
//        $songs=Song::paginate(30);
        $song = $user ->Songs;
//        dd($user->UserId);
        return view('layouts.livestreamplayer.user_detail', ['user' => $user, 'song' => $song]);
    }

    public function destroy(Request $request){
        return (User::destroy($request->input('userIds')));

    }


    public function update(Request $request, $id){

        $validateRules =[
            'nickname' => 'required'
        ];
        $validateMess =[
            'nickname.required' => 'Please enter your nickname',
        ];
        $request->validate($validateRules,$validateMess);
        $validator = Validator::make($request->all(), $validateRules, $validateMess);
        if($validator->failed()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $updateUser=Users::find($id);
        $updateUser->Nickname = $request->get('nickname');

        if($updateUser->Type == 0){
            $updateUser->FacebookId=$request->get('facebookId');
        }else{
            $updateUser->Email=$request->get('email');
        }
        $updateUser->Phone=$request->get('phone');

        $updateUser->Birthday=$request->get('birthday');

        if (!is_null($request->get('password'))){
            $pass = $request->get('password');
            $newpass = md5($pass);
            $updateUser->Password=$newpass;
        }

        $updateUser->Role=$request->get('role');

        $updateUser->save();
        return redirect()->back();
    }

    public function delete($userId){
        Users::destroy($userId);
        return redirect()->route('admin.livestreamplayer.users');
    }





}
