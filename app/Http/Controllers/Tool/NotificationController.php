<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Models\Tool\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function index()
    {
        return view('tools.notification', [
            'notifications' => Notification::orderBy('StartDate', 'desc')->get(),
        ]);
    }

    public function show($notificationId)
    {
        return view('tools.notification_edit', [
            'notification' => Notification::find($notificationId)
        ]);
    }

    public function update(Request $request, $notificationId)
    {
        $request->validate([
            'AppId' => 'required',
            'Type' => 'required|numeric',
            'StartDate' => 'required|date_format:Y-m-d',
            'ExpiredDate' => 'nullable|date_format:Y-m-d',
            'Notification' => 'required|array',
            'Platform'=>'required',
            'Notification.title' => 'required',
            'Notification.text' => 'required',
        ], [
            'Notification.title.required' => 'The notification title field is required.',
            'Notification.text.required' => 'The notification text field is required.',
        ]);
        $notificationContent = $request->get('Notification');
        if ($notificationContent["button"]["title"] == null) unset($notificationContent["button"]["title"]);
        if ($notificationContent["button"]["link"] == null) unset($notificationContent["button"]["link"]);
        if (count($notificationContent["button"]) == 0) unset($notificationContent["button"]);
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->Type = $request->get('Type');
            $notification->AppId = $request->get('AppId');
            $notification->Platform = $request->get('Platform');
            $notification->StartDate = $request->get('StartDate');
            $notification->ExpiredDate = $request->get('ExpiredDate');
            $notification->Notification = json_encode($notificationContent);
            $notification->save();
            return back()->with('actionSuccess', true);
        } else {
            return back()
                ->withInput()
                ->withErrors("Notification not found!", 'error');
        }
    }

    public function create()
    {
        return view('tools.notification_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'AppId' => 'required',
            'Type' => 'required|numeric',
            'StartDate' => 'required|date_format:Y-m-d',
            'ExpiredDate' => 'nullable|date_format:Y-m-d',
            'Platform'=>'required',
            'Notification' => 'required|array',
            'Notification.title' => 'required',
            'Notification.text' => 'required',
        ], [
            'Notification.title.required' => 'The notification title field is required.',
            'Notification.text.required' => 'The notification text field is required.',
        ]);
        $notificationContent = $request->get('Notification');
        if ($notificationContent["button"]["title"] == null) unset($notificationContent["button"]["title"]);
        if ($notificationContent["button"]["link"] == null) unset($notificationContent["button"]["link"]);
        if (count($notificationContent["button"]) == 0) unset($notificationContent["button"]);
        $notification = new Notification();
        $notification->Type = $request->get('Type');
        $notification->AppId = $request->get('AppId');
        $notification->Platform = $request->get('Platform');
        $notification->StartDate = $request->get('StartDate');
        $notification->ExpiredDate = $request->get('ExpiredDate');
        $notification->Notification = json_encode($notificationContent);
        $notification->save();
        return redirect()->route('admin.tools.notification.show',$notification->Id)->with('actionSuccess', true);
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return Notification::class;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return array(
            "deleteUrl" => route('admin.tools.notification.delete'),
            "recordName" => "notifications",
        );
    }
}
