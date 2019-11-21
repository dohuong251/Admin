<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Apps\Apps;
use App\Models\Apps\Category;
use function foo\func;

class AppController extends Controller
{
    //
    public function index()
    {
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
