<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no, user-scalable=0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin')</title>
    <style>
        #loader {
            top: 0;
            left: 0;
            transition: all .3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000;
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1s infinite ease-in-out;
            animation: sk-scaleout 1s infinite ease-in-out
        }

        @-webkit-keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                opacity: 0
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 0
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/dist/style.css?1" rel="stylesheet">
    @yield('css')
</head>
<body class="app ovY-a pr-0">
<div id="loader">
    <div class="spinner"></div>
</div>
<script>
    window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function () {
            loader.classList.add('fadeOut');
        }, 300);
    });

    // thay ảnh avatar của user thành mặc định nếu load lỗi
    function onLoadAvatarError(element) {
        element.src = "/images/icon/avatar.png";
        element.className += " bg-secondary";
        element.onerror = null;
    }</script>
<div>
    <div class="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="{{route('admin.home')}}">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img style="width: 65px;height: 65px;object-fit: contain;" src="/images/icon/mdc.png?1" alt="">
                                    </div>
                                </div>
                                <div class="peer peer-greed"><h5 class="lh-1 mB-0 logo-text">Adminator</h5></div>
                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="sidebar-menu scrollable pos-r">
                {{--                <li class="nav-item mT-30 actived">--}}
                {{--                    <a class="sidebar-link" href="{{route('admin.home')}}">--}}
                {{--                        <span class="icon-holder"><i class="c-white-500 ti-home"></i> </span>--}}
                {{--                        <span class="title">Dashboard</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                <li class="nav-item dropdown{{Str::contains(Request()->route()->getPrefix(),"admin/livestreamplayer")?" open":""}}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-white-500 ti-layout-list-thumb"></i> </span>
                        <span class="title">Live Stream Player</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{strpos(request()->route()->getName(),"admin.lsp.user")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.lsp.user.index')}}">Users</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.lsp.streams")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.lsp.streams.index')}}">Streams</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.lsp.review_streams")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.lsp.review_streams')}}">Review Copyright Streams</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.lsp.messages")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.lsp.messages.index')}}">Messages</a>
                        </li>
                        <li class="nav-item dropdown {{strpos(request()->route()->getName(),"admin.lsp.analytic")===0?'active open':''}}">
                            <a href="javascript:void(0);">
                                <span>Analytics</span>
                                <span class="arrow"><i class="ti-angle-right"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{strpos(request()->route()->getName(),"admin.lsp.analytic.statistics")===0?'active':''}}">
                                    <a href="{{route('admin.lsp.analytic.statistics')}}">Statistics</a>
                                </li>
                                <li class="{{strpos(request()->route()->getName(),"admin.lsp.analytic.realtime")===0?'active':''}}">
                                    <a href="{{route('admin.lsp.analytic.realtime')}}">Realtime</a>
                                </li>
                                <li class="{{strpos(request()->route()->getName(),"admin.lsp.analytic.country")===0?'active':''}}">
                                    <a href="{{route('admin.lsp.analytic.country')}}">Country</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown{{Request()->route()->getPrefix()=='admin/sales'? ' open':''}}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-white-500 ti-map"></i> </span>
                        <span class="title">Sales</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{strpos(request()->route()->getName(),"admin.sales.order")===0?'active':''}}">
                            <a href="{{route('admin.sales.order')}}">Orders</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.sales.subscription")===0?'active':''}}">
                            <a href="{{route('admin.sales.subscription')}}">Subscription</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.sales.license")===0?'active':''}}">
                            <a href="{{route('admin.sales.license')}}">License</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown{{Request()->route()->getPrefix()=='admin/tools'? ' open':''}}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-white-500 ti-files"></i> </span>
                        <span class="title">Tools</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{strpos(request()->route()->getName(),"admin.tools.config")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.config')}}">Configs</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.tools.sendBroadcast")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.sendBroadcast')}}">Send Broadcast</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.tools.notification")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.notification')}}">Notification</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.tools.testRule")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.testRule')}}">Test Rules</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{strpos(request()->route()->getName(),"admin.apps")===0 && strpos(request()->route()->getName(),"admin.apps.overview")===0 ?'open':''}}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-white-500 ti-email"></i> </span>
                        <span class="title">Apps</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="{{strpos(request()->route()->getName(),"admin.apps.overview")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.apps.overview')}}">Overview</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.apps.index")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.apps.index')}}">Manage Apps</a>
                        </li>
                    </ul>

                </li>
                <li class="nav-item {{strpos(request()->route()->getName(),"admin.promotions")===0?'active':''}}">
                    <a class="sidebar-link" href="{{route('admin.promotions.index')}}">
                        <span class="icon-holder"><i class="c-white-500 ti-package"></i> </span>
                        <span class="title">Promo</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                <ul class="nav-left">
                    <li>
                        <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                            <i class="ti-menu"></i>
                        </a>
                    </li>
                    <li class="search-box">
                        <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                            <i class="search-icon ti-search pdd-right-10"></i>
                            <i class="search-icon-close ti-close pdd-right-10"></i>
                        </a>
                    </li>
                    <li class="search-input">
                        <form action="{{url()->current()}}" method="get">
                            {{--                            @csrf--}}
                            <input class="form-control" name="query" type="text" placeholder="Search...">
                        </form>
                    </li>
                </ul>
                <ul class="nav-right mr-3">
                    <li class="notifications dropdown">
                        @if($notifications->count())
                            <span class="counter bgc-red">{{$notifications->count()}}</span>
                        @endif
                        <a href="" class="dropdown-toggle no-after" data-toggle="dropdown" aria-expanded="false">
                            <i class="ti-bell"></i>
                        </a>
                        <ul class="dropdown-menu text-break" style="cursor: auto">
                            {{--                            <li class="pX-20 pY-15 bdB">--}}
                            {{--                                <i class="ti-bell pR-10"></i>--}}
                            {{--                                <span class="fsz-sm fw-600 c-grey-900">Notifications</span>--}}
                            {{--                            </li>--}}
                            <li>
                                <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm ps" style="max-height: calc(100vh - 65px - 15px);" id="notification-dropdown">
                                    <button class="position-sticky bdB btn w-100 bgc-white btn-refresh-check-rule" style="top: 0">
                                        <i class="fa5 fa-refresh {{\App\Console\Commands\CheckParseUrl::isTaskRunning() ? "fa-spin":""}}"></i>
                                    </button>
                                    @forelse ($notifications as $notification)
                                        <li>
                                            <div class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                                                {{--                                                <div class="peer mR-15">--}}
                                                {{--                                                    <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">--}}
                                                {{--                                                </div>--}}
                                                <div class="peer peer-greed">
                                                    <div class="fw-500 {{$notification->status==2 ? "c-yellow-700" : ""}} {{$notification->status==3 ? "text-danger" : ""}}">{{$notification->name}}</div>
                                                    <div>
                                                        <span class="c-grey-600">URL: </span>{{$notification->url}}
                                                        <button class="btn btn-outline-secondary btn-sm ml-2 copy-to-clipboard" data-copy-value="{{$notification->url}}" title="copy">
                                                            <i class="fa fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @if($notification->parse_url)
                                                        <div class="text-dark">
                                                            <span class="c-grey-600">Parsed URL: </span>{{$notification->parse_url}}
                                                            <button class="btn btn-outline-secondary btn-sm ml-2 copy-to-clipboard" data-copy-value="{{$notification->parse_url}}" title="copy">
                                                                <i class="fa fa-copy"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    @if(is_array($notification->log) && count($notification->log))
                                                        <a href="#" onclick="return getRuleLogs({{$notification->id}});">Xem Log</a>
                                                    @endif
                                                    <p class="m-0" title="{{$notification->created_at->format("d/m/Y h:m")}}">
                                                        <small class="fsz-xs">{{$notification->created_at->locale("vi_VN")->diffForHumans()}}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="my-3 text-center">
                                            <i class="fas fa-check-circle fa-5x text-success"></i>
                                        </p>
                                    @endforelse
                                </ul>
                            </li>
                            {{--                            <li class="pX-20 pY-15 ta-c bdT">--}}
                            {{--                                <span><a href="" class="c-grey-600 cH-blue fsz-sm td-n">View All Notifications <i class="ti-angle-right fsz-xs mL-10"></i></a></span>--}}
                            {{--                            </li>--}}
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <main class="main-content bgc-grey-100">
            <div id="mainContent">
                <div class="container-fluid bg-white bd">
                    <div class="loading-icon" style="display: none"></div>
                    @yield('content')
                </div>
            </div>
        </main>
        <footer class="bdT ta-c pY-30 lh-0 fsz-sm c-grey-600">
            <span>Copyright © 2019 Designed by <a href="http://www.mdcgate.com/apps/" target="_blank" title="">MDC</a>. All rights reserved.</span>
        </footer>
    </div>
</div>

<div class="modal fade" id="notification-detail-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logs Parse Rule:
                    <span class="parse-rule-name"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-break">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                {{--                <button type="button" class="btn btn-primary">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>
@verbatim
    <script id="rule-logs-template" type="text/x-handlebars-template">
{{#logs}}
        {{#is_step_exception step}}
        <div class="border rounded p-10 text-danger mb-2 mt-2">
            <div>{{step}}</div>
                    <div class="step-result">{{result}}</div>
                </div>
                {{else}}
        <div class="border rounded p-10 mb-2 mt-2 clearfix step-result">
            <i class="fa fa-caret-down float-right p-5 cur-p collapse-step-result transition-normal"></i>
            <span class="transition-normal">{{step}}: </span>
                    <div class="d-inline">{{action}}</div>
                    <div class="text-success step-result-text transition-normal">{{result}}</div>
                </div>
                {{/is_step_exception}}
        {{/logs}}

    </script>
@endverbatim

<script src="/js/vendors/jquery.min.js"></script>
<script type="text/javascript" src="/js/dist/vendor.js"></script>
<script type="text/javascript" src="/js/dist/bundle.js"></script>
<script src="/js/vendors/handlebars.min.js"></script>
<script src="/js/vendors/lazyload.min.js"></script>
<script src="/js/vendors/sweetalert2.all.min.js"></script>
<script src="{{mix("/js/vendors/tooltip.js")}}"></script>
<script src="{{mix("/js/vendors/modal.js")}}"></script>
<script src="/js/dist/main.js"></script>
<script>
    let deleteOptions = {
        deleteUrl: "{!! $deleteUrlDetailPage ?? $deleteUrl ?? ""!!}",
        recordName: "{!! $recordNameDetailPage ?? $recordName ?? "" !!}",
    };
    @error('warningMessage')
    $(document).ready(function () {
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        }).fire({
            icon: 'error',
            title: '{{session('errors')->first('warningMessage')}}',
        });
    });
    @enderror

    $(function () {
        $("body").on('click', '.collapse-step-result', function () {
            $(this).toggleClass('fa-rotate-90')
                // .siblings('div:not(.step-result-text)').toggleClass('d-none')
                .siblings('.step-result-text').toggleClass('ellipsis');
        }).on("click", ".copy-to-clipboard", function (e) {
            e.preventDefault();
            let text = $(this).data("copy-value");
            if (text.length) {
                let inputToCopy = document.createElement("input");
                document.body.append(inputToCopy);
                inputToCopy.value = text;
                inputToCopy.select();
                inputToCopy.setSelectionRange(0, 99999)
                document.execCommand("copy");
                inputToCopy.remove();
            }
        }).on("click", "#notification-dropdown", function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        Handlebars.registerHelper('is_step_exception', function (str, options) {
            if (str === "exception") {
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });

        let reportRuleLogsTemplate = Handlebars.compile(document.getElementById("rule-logs-template").innerHTML),
            ruleLogModal = $("#notification-detail-modal");

        window.getRuleLogs = function (id) {
            $.ajax({
                url: "{{route("admin.tools.getRuleLogs")}}",
                method: "POST",
                data: {
                    id,
                },
                success: function (data) {
                    if (data.result && Array.isArray(data.logs) && data.logs.length) {
                        ruleLogModal.find(".modal-body").html(reportRuleLogsTemplate(data));
                        ruleLogModal.find(".parse-rule-name").text(data.name);
                        ruleLogModal.modal("show");
                    }
                }
            })
        }

        let refreshRuleBtn = $(".btn-refresh-check-rule"), refreshRuleCheckInterval;

        function checkParseRuleState() {
            refreshRuleCheckInterval = setInterval(function () {
                $.ajax({
                    url: "{{route("admin.tools.checkParseRuleServiceState")}}",
                    success: function (data) {
                        if (data.result) {
                            if (data.running) {
                                refreshRuleBtn.find("i").addClass("fa-spin");
                                clearInterval(refreshRuleCheckInterval);
                            } else {
                                refreshRuleBtn.find("i").removeClass("fa-spin");
                            }
                        }
                    }
                })
            }, 30000);
        }

        refreshRuleBtn.click(function () {
            $.ajax({
                method: "post",
                url: "{{route("admin.tools.startCheckRule")}}",
                beforeSend: () => {
                    refreshRuleBtn.find("i").addClass("fa-spin");
                },
                success: function () {
                    checkParseRuleState();
                }
            })
        })

        @if(\App\Console\Commands\CheckParseUrl::isTaskRunning())
        checkParseRuleState();
        refreshRuleBtn.find("i").addClass("fa-spin");
        @endif
    });
</script>
@yield('js')
</body>
</html>
