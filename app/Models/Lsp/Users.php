<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Users extends Base
{
    protected $table = 'users';
    protected $primaryKey = 'UserId';
    protected $hidden = ['Password', 'Token'];

    public function songs()
    {
        return $this->hasMany('App\Models\Lsp\Songs', 'UserId');
    }

    public function playlists()
    {
        return $this->hasMany('App\Models\Lsp\Playlists', 'UserId');
    }

    public function rating()
    {
        return $this->hasMany('App\Models\Lsp\Rating', 'UserId');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\Lsp\Chats', 'UserId');
    }

    public function likedSong()
    {
        return $this->hasMany('App\Models\Lsp\Likes', 'UserId');
    }

    // stream bị report
    public function streamReported()
    {
        return $this->hasMany('App\Models\Lsp\Copyrightstreams', 'UserId');
    }

    // stream đã report
    public function reportStream()
    {
        return $this->hasMany('App\Models\Lsp\Copyrightstreams', 'OwnerId');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Lsp\Posts', 'UserId');
    }

    public function sendNotifications()
    {
        return $this->hasMany('App\Models\Lsp\Notifications', 'SenderId');
    }

    public function receivedNotifications()
    {
        return $this->hasMany('App\Models\Lsp\Notifications', 'ReceiverId');
    }

    public function broadcasts()
    {
        return $this->hasMany('App\Models\Lsp\Broadcasts', 'UserId');
    }

    public function cloudtokens()
    {
        return $this->hasMany('App\Models\Lsp\Cloudtokens', 'UserId');
    }

    public function apnTokens()
    {
        return $this->hasMany('App\Models\Lsp\APNTokens', 'UserId');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Lsp\Comments', 'UserId');
    }

    public function likedPost()
    {
        return $this->hasMany('App\Models\Lsp\Postlikes', 'UserId');
    }

    public function reportChannel()
    {
        return $this->hasMany('App\Models\Lsp\ReportChannel', 'ReportedUserId');
    }

    public function blacklist()
    {
        return $this->hasOne('App\Models\Lsp\Blacklist', 'UserId');
    }

    public function autoblock()
    {
        return $this->hasMany('App\Models\Lsp\Autoblock', 'OwnerId');
    }

    public function group()
    {
        return $this->hasMany('App\Models\Lsp\Groups', 'UserId');
    }

    public function sendMessages()
    {
        return $this->hasMany('App\Models\Lsp\Messages', 'FromUserId');
    }

    public function receiveMessages()
    {
        return $this->hasMany('App\Models\Lsp\Messages', 'ToUserId');
    }

    public function subscriber(){
        return $this->hasMany('App\Models\Lsp\Subscribe','UserId');
    }

    public function subscribing(){
        return $this->hasMany('App\Models\Lsp\Subscribe','TargetUserId');
    }
}
