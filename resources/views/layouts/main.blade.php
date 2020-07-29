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
                        <li class="{{strpos(request()->route()->getName(),"admin.apps.index")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.apps.index')}}">Manage Apps</a>
                        </li>
                        <li class="{{strpos(request()->route()->getName(),"admin.apps.overview")===0?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.apps.overview')}}">Overview</a>
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
<script src="/js/vendors/jquery.min.js"></script>
<script type="text/javascript" src="/js/dist/vendor.js"></script>
<script type="text/javascript" src="/js/dist/bundle.js"></script>
<script src="/js/vendors/lazyload.min.js"></script>
<script src="/js/vendors/sweetalert2.all.min.js"></script>
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
</script>
@yield('js')
</body>
</html>
