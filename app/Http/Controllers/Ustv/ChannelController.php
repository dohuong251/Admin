<?php

namespace App\Http\Controllers\Ustv;

use App\Http\Controllers\model;
use App\Models\Ustv\Channel;
use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function allChannelIndex(Request $request)
    {
        $sort = $request->get('sort', 'watch_counter');
        $order = $request->get('order', 'desc');
        $searchQuery = Channel::with('url')
            ->where("id_channel_type", 1)
            ->where('id_type_tv', $request->get('id_type_tv', 9))
            ->whereIn('id_type_tv', [9, 12])
            ->orderBy($sort, $order);

        if ($request->get('query') != null && $request->get('filter') != null) {
            $searchQuery->where($request->get('filter'), 'like', '%' . $request->get('query') . '%');
        }

        return view('ustv.channels', [
            'channels' => $searchQuery->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'))->appends(Request()->except('page'))
        ]);
    }

    public function allHotChannelIndex()
    {

    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function storeUrl()
    {

    }

    public function updateUrl()
    {

    }

    public function deleteUrl()
    {

    }
    //

    /**
     * @inheritDoc
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
    }

    /**
     * @inheritDoc
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
    }
}
