<?php

namespace App\Http\Controllers\Ustv;

use App\Http\Controllers\model;
use App\Http\Requests\UstvChannelRequest;
use App\Http\Requests\UstvUrlRequest;
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
            'channels' => $searchQuery->paginate(Config::get('constant.PAGINATION_RECORD_PER_PAGE'))->appends(Request()->except('page')),
            'order' => $order,
            'sort' => $sort
        ]);
    }

    public function allHotChannelIndex()
    {

    }

    public function create()
    {
        return view('ustv.channel_create');
    }

    public function store(UstvChannelRequest $request)
    {
        $request->validated();
        $channel = Channel::create([
            "symbol" => $request->get("symbol"),
            "description" => $request->get("description") ?? "",
            "icon_name" => $request->get("icon_name"),
            "id_type_tv" => $request->get("id_type_tv"),
        ]);

        return redirect(route('admin.ustv.channels.edit', $channel->id));
    }

    public function edit($channelId)
    {
        return view('ustv.channel_edit', [
            'channel' => Channel::find($channelId)
        ]);
    }

    public function update($channelId, UstvChannelRequest $request)
    {

    }

    public function storeUrl(UstvUrlRequest $request)
    {

    }

    public function updateUrl(UstvUrlRequest $request)
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
        return array(
            "deleteUrl" => route("admin.ustv.channels.delete"),
            "recordName" => "Kênh",
        );
    }

    /**
     * @inheritDoc
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return Channel::class;
    }
}
