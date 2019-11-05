<?php

namespace App\Http\Controllers\lsp;

use App\Http\Controllers\Controller;
use App\Models\LSP\Messages;
use App\Models\LSP\Users;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function index(Request $request)
    {
        $userId = $request->get('userid', 15);
        $user = Users::find($userId);

        $conversations = Messages::with('sendUser', 'receiveUser')
            ->select('FromUserId', 'ToUserId')
            ->where('FromUserId', $userId)
            ->orWhere('ToUserId', $userId)
            ->orderBy('Time', 'desc')
            ->get();

        return view('lsp.message', [
            'user' => $user,
//            'conversationUsers' => $conversations->pluck('sendUser')->merge($conversations->pluck('receiveUser'))->unique(),
            'conversationUsers' => $conversations->map(function ($conversation) {
                return [$conversation->sendUser, $conversation->receiveUser];
            })->flatten()->unique(),
        ]);
    }

    public function store(Request $request)
    {
        $validateRules = [
            'Message' => 'required',
            'ToUserId' => 'required'
        ];
        $request->validate($validateRules);
        if (is_array($request->get('ToUserId'))) {
            $messages = [];
            foreach ($request->get('ToUserId') as $toUserId) {
                array_push($messages, [
                    'FromUserId' => 15,
                    'Message' => $request->get('Message'),
                    'Time' => now(),
                    'ToUserId' => $toUserId
                ]);
            }
            Messages::insert($messages);
        } else {
            $sendMessage = new Messages();
            $sendMessage->FromUserId = 15;
            $sendMessage->Message = $request->get('Message');
            $sendMessage->Time = now();
            $sendMessage->ToUserId = $request->get('ToUserId');
            $sendMessage->save();
        }

        if ($request->has('XHR') && $request->get('XHR')) {
            // ajax request
            $request->request->add(['MessageId' => $sendMessage->MessageId]);
            return $request;
        } else {
            return back();
        }

    }


    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return Messages::class;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return array(
            "deleteUrl" => route('admin.lsp.messages.delete'),
//            "recordName" => "Thành Viên",
        );
    }
}
