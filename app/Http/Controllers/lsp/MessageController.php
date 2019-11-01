<?php

namespace App\Http\Controllers\lsp;

use App\Models\LSP\Messages;
use App\Models\LSP\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class MessageController extends Controller
{
    //
    public function index(Request $request)
    {
//        dd(Messages::find(98623),date_format(date_create(Messages::find(98623)->Time),'H:i d/m/Y'));
        $userId = $request->get('userid', 15);
        $user = Users::find($userId);
//        $conversations = Messages::with('sendUser', 'receiveUser')->where('FromUserId', $userId)
//            ->orWhere('ToUserId', $userId)
//            ->orderBy('Time', 'asc')
//            ->get();

        $conversations = Messages::with('sendUser', 'receiveUser')->select('FromUserId', 'ToUserId')->where('FromUserId', $userId)
            ->orWhere('ToUserId', $userId)
            ->groupBy('FromUserId', 'ToUserId')
            ->orderBy('Time', 'desc')
            ->get();
//        dd($conversations->map(function ($conversation) {
//            return [$conversation->sendUser, $conversation->receiveUser];
//        })->flatten()->unique());
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

    public function delete(Request $request)
    {
        if (Messages::destroy($request->get('Id'))) {
            return;
        } else {
            return abort(500);
        }
    }
}
