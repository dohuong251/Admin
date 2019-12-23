@extends('layouts.main')
@section('title', 'Messages')
@section('css')
    <link rel="stylesheet" href="/css/vendors/select2.min.css"/>
@endsection
@section('js')

    <script src="/js/vendors/select2.min.js"></script>
    <script src="/js/vendors/moment.min.js"></script>
    <script src="/js/vendors/moment_vi.js"></script>
    <script src="/js/vendors/jquery.form.min.js"></script>
    <script src="/js/vendors/popper.min.js"></script>
    <script src="/js/vendors/bootstrap.min.js"></script>
    <script src="/js/lsp/message.js"></script>
@endsection

@section('content')
    <nav class="mX-15">
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Messages
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('admin.lsp.user.show',$user->UserId)}}">{{$user -> Nickname}}</a>
            </li>

            <li class="ml-auto">
                <a href="" class="td-n c-grey-900 cH-blue-500 fsz-md" title="Gửi tin nhắn" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-commenting-o align-baseline"></i>
                </a>
            </li>
        </ol>

    </nav>

    <div class="peers fxw-nw pos-r">
        <div class="peer bdR" id="chat-sidebar">
            <div class="layers h-100">
                <div class="bdB layer w-100">
                    <input type="text" placeholder="Search contacts..." name="chatSearch" class="form-constrol p-15 bdrs-0 w-100 bdw-0">
                </div>
                <div class="layer w-100 fxg-1 scrollable pos-r ps ps--active-y">
                    @foreach($conversationUsers as $conversationUser)
                        @if($conversationUser)
                            <div class="peers fxw-nw ai-c p-20 messenger bgc-white bgcH-grey-50 cur-p" data-toggle="#mess-{{$conversationUser->UserId}}">
                                <div class="peer">
                                    @if($conversationUser->Avatar)
                                        <img src="{{$conversationUser->Avatar}}" alt="" class="user-avatar w-3r h-3r bdrs-50p" onerror="onLoadAvatarError(this)">
                                    @else
                                        <img src="/images/icon/avatar.png" alt="" class="user-avatar w-3r h-3r bdrs-50p bg-secondary">
                                    @endif
                                </div>
                                <div class="peer peer-greed pL-20">
                                    <h6 class="mB-0 lh-1 fw-400 information">{{$conversationUser->Nickname}}</h6>
                                    <small class="lh-1 c-green-500 information">{{$conversationUser->Email??$conversationUser->FacebookId}}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="peer peer-greed" id="chat-box">
            @foreach($conversationUsers as $conversationUser)
                @if($conversationUser)
                    <div class="layers h-100 message-content d-none" id="mess-{{$conversationUser->UserId}}">
                        <div class="layer w-100 shadow-sm">
                            <div class="peers fxw-nw jc-sb ai-c pY-20 pX-30 bgc-white">
                                <div class="peers ai-c">
                                    <div class="peer d-n@md+">
                                        <a href="" title="" class="td-n c-grey-900 cH-blue-500 mR-30 chat-sidebar-toggle">
                                            <i class="ti-menu"></i>
                                        </a>
                                    </div>
                                    <div class="peer mR-20">
                                        @if($conversationUser->Avatar)
                                            <img src="{{$conversationUser->Avatar}}" alt="" class="user-avatar w-3r h-3r bdrs-50p" onerror="onLoadAvatarError(this)">
                                        @else
                                            <img src="/images/icon/avatar.png" alt="" class="user-avatar w-3r h-3r bdrs-50p bg-secondary">
                                        @endif
                                    </div>
                                    <div class="peer">
                                        <h6 class="lh-1 mB-0">
                                            <a href="{{route('admin.lsp.user.show',$conversationUser->UserId)}}" target="_blank">{{$conversationUser->Nickname}}</a>
                                        </h6>
                                        <i class="fsz-sm lh-1">{{$conversationUser->Email??$conversationUser->FacebookId}}</i>
                                    </div>
                                </div>

{{--                                <div class="peers">--}}
{{--                                    <a href="" class="peer td-n c-grey-900 cH-blue-500 fsz-md" title="Gửi tin nhắn" data-toggle="modal" data-target="#exampleModal">--}}
{{--                                        <i class="fa fa-commenting-o align-baseline"></i>--}}
{{--                                    </a>--}}
{{--                                </div>--}}

                            </div>
                        </div>
                        <div class="layer w-100 fxg-1 scrollable pos-r ps">
                            {{--                            <div class="p-20 gapY-15">--}}
                            <div class="p-20">
                                @foreach(
                                \App\Models\Lsp\Messages::where([['FromUserId',$conversationUser->UserId],['ToUserId',$user->UserId]])
                                 ->orWhere([['ToUserId',$conversationUser->UserId],['FromUserId',$user->UserId]])
                                 ->orderBy('Time','asc')
                                 ->get() as $message
                                )
                                    @if($message->FromUserId==$user->UserId)
                                        <div class="peers fxw-nw ai-fe message-container message-host">
                                            <div class="peer ord-1 mL-20">
                                                @if($user->Avatar)
                                                    <img class="user-avatar w-2r bdrs-50p" src="{{$user->Avatar}}" alt="" onerror="onLoadAvatarError(this)">
                                                @else
                                                    <img class="user-avatar w-2r bdrs-50p bg-secondary" src="/images/icon/avatar.png" alt="">
                                                @endif
                                            </div>
                                            <div class="peer peer-greed ord-0">
                                                <div class="layers ai-fe gapY-10">
                                                    <div class="layer message-box">
                                                        <div class="peers fxw-nw ai-c pY-3 pX-10  bdrs-2 lh-3/2">
                                                            <span class="text-break whs-pl">{{date_format(date_create($message->Time),'H:i d/m/Y')}} - {{$message->Message}}</span>
                                                            <i class="fa fa-trash text-danger fsz-xs ml-2 cur-p delete-message" data-id="{{$message->MessageId}}"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="peers fxw-nw message-container message-guest">
                                            <div class="peer mR-20">
                                                @if($conversationUser->Avatar)
                                                    <img class="user-avatar w-2r bdrs-50p" src="{{$conversationUser->Avatar}}" alt="" onerror="onLoadAvatarError(this)">
                                                @else
                                                    <img class="user-avatar w-2r bdrs-50p bg-secondary" src="/images/icon/avatar.png" alt="">
                                                @endif
                                            </div>
                                            <div class="peer peer-greed">
                                                <div class="layers ai-fs gapY-5">
                                                    <div class="layer message-box">
                                                        <div class="peers fxw-nw ai-c pY-3 pX-10 bdrs-2 lh-3/2">
                                                            <i class="fa fa-trash text-danger fsz-xs mr-2 cur-p delete-message" data-id="{{$message->MessageId}}"></i>
                                                            <span class="text-break whs-pl">{{$message->Message}} - {{date_format(date_create($message->Time),'H:i d/m/Y')}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @if($user->UserId==15)
                            <div class="layer w-100">
                                <div class="p-20 bdT bgc-white">
                                    <div class="pos-r">
                                        <form class="submit-message" action="{{route('admin.lsp.messages.store')}}" method="post">
                                            @csrf
                                            <input name="ToUserId" value="{{$conversationUser->UserId}}" type="hidden">
                                            <input type="text" name="Message" class="form-control bdrs-10em m-0" placeholder="Say something..." required>
                                            <button type="submit" class="btn btn-primary bdrs-50p w-2r p-0 h-2r pos-a r-1 t-1">
                                                <i class="fa fa-paper-plane-o"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <script>let adminAvatar = "{!! \App\Models\Lsp\Users::find(15)->Avatar !!}";</script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="post" action="{{route('admin.lsp.messages.store')}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gửi tin nhắn</h5>
                    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--                        <span aria-hidden="true">&times;</span>--}}
                    {{--                    </button>--}}
                </div>
                <div class="modal-body">
                    @csrf
                    <input name="Message" value="" placeholder="Nhập tin nhắn..." class="form-control mb-3" required>
                    <select class="select2-multiple custom-select" name="ToUserId[]" multiple="multiple" required>
                        @foreach($conversationUsers as $conversationUser)
                            @if($conversationUser)
                                <option value="{{$conversationUser->UserId}}">{{$conversationUser->Nickname}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
