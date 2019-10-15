<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Users extends Base
{
    protected $table = 'users';
    protected $primaryKey = 'UserId';
    protected $hidden = ['Password', 'Token'];

    public function songs()
    {
        return $this->hasMany('App\Models\LSP\Songs', 'UserId');
    }

    public function playlists()
    {
        return $this->hasMany('App\Models\LSP\Playlists', 'UserId');
    }

    public function rating()
    {
        return $this->hasMany('App\Models\LSP\Rating', 'UserId');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\LSP\Chats', 'UserId');
    }

    public function likedSong()
    {
        return $this->hasMany('App\Models\LSP\Likes', 'UserId');
    }

    // stream bị report
    public function streamReported()
    {
        return $this->hasMany('App\Models\LSP\Copyrightstreams', 'UserId');
    }

    // stream đã report
    public function reportStream()
    {
        return $this->hasMany('App\Models\LSP\Copyrightstreams', 'OwnerId');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\LSP\Posts', 'UserId');
    }

    public function sendNotifications()
    {
        return $this->hasMany('App\Models\LSP\Notifications', 'SenderId');
    }

    public function receivedNotifications()
    {
        return $this->hasMany('App\Models\LSP\Notifications', 'ReceiverId');
    }

    public function broadcasts()
    {
        return $this->hasMany('App\Models\LSP\Broadcasts', 'UserId');
    }

    public function cloudtokens()
    {
        return $this->hasMany('App\Models\LSP\Cloudtokens', 'UserId');
    }

    public function apnTokens()
    {
        return $this->hasMany('App\Models\LSP\APNTokens', 'UserId');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\LSP\Comments', 'UserId');
    }

    public function likedPost()
    {
        return $this->hasMany('App\Models\LSP\Postlikes', 'UserId');
    }

    public function reportChannel()
    {
        return $this->hasMany('App\Models\LSP\ReportChannel', 'ReportedUserId');
    }

    public function blacklist()
    {
        return $this->hasOne('App\Models\LSP\Blacklist', 'UserId');
    }

    public function autoblock()
    {
        return $this->hasMany('App\Models\LSP\Autoblock', 'OwnerId');
    }

    public function group()
    {
        return $this->hasMany('App\Models\LSP\Groups', 'UserId');
    }

    public function sendMessages()
    {
        return $this->hasMany('App\Models\LSP\Messages', 'FromUserId');
    }

    public function receiveMessages()
    {
        return $this->hasMany('App\Models\LSP\Messages', 'ToUserId');
    }

    public function subscriber(){
        return $this->hasMany('App\Models\LSP\Subscribe','UserId');
    }

    public function subscribing(){
        return $this->hasMany('App\Models\LSP\Subscribe','TargetUserId');
    }
}
