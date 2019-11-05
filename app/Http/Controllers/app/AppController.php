<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\APPS\Apps;
use App\Models\APPS\Category;
use function foo\func;

class AppController extends Controller
{
    //
    public function index()
    {
//        Apps::select('app'.'app_id', 'app_version'.'icon_url', 'app_version'.'app_version_name')

//        foreach(Apps::with(['appVersions' => function ($query) {
//            $query->orderBy('last_update', 'desc');
//        }])->orderBy('show', 'desc')->get() as $app){
//            dump($app->appVersions);
//        }
        return view('apps.apps', [
            'apps' => Apps::join('app_version', function ($join) {
                $join->on('app_version.app_id', '=', 'app.app_id');
            })
                ->groupBy('app.app_id')
                ->orderBy('show', 'desc')
                ->orderBy('last_update', 'desc')
                ->get(),

        ]);
    }

    public function show($appId)
    {

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
