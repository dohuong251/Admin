<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    {{--    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">--}}
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
    <link href="/css/dist/style.css" rel="stylesheet">
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
                                        <img style="width: 65px;height: 65px;object-fit: contain;" src="/images/icon/mdc.png" alt="">
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
                <li class="nav-item mT-30 actived">
                    <a class="sidebar-link" href="{{route('admin.home')}}">
                        <span class="icon-holder"><i class="c-blue-500 ti-home"></i> </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-orange-500 ti-layout-list-thumb"></i> </span>
                        <span class="title">Live Stream Player</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="sidebar-link" href="{{route('admin.lsp.user.index')}}">Users</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="{{route('admin.lsp.streams.index')}}">Streams</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="{{route('admin.lsp.messages.index')}}">Messages</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="{{route('admin.lsp.analytic')}}">Analytics</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-purple-500 ti-map"></i> </span>
                        <span class="title">Sales</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('admin.sales.order')}}">Orders</a>
                        </li>
                        <li>
                            <a href="{{route('admin.sales.subscription')}}">Subscription</a>
                        </li>
                        <li>
                            <a href="{{route('admin.sales.license')}}">License</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder"><i class="c-red-500 ti-files"></i> </span>
                        <span class="title">Tools</span>
                        <span class="arrow"><i class="ti-angle-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="sidebar-link" href="{{route('admin.tools.config')}}">Configs</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="{{route('admin.tools.sendBroadcast')}}">Send Broadcast</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="{{route('admin.tools.notification')}}">Notification</a>
                        </li>
                        <li>
                            <a class="sidebar-link" href="{{route('admin.tools.testRule')}}">Test Rules</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{route('admin.apps.index')}}">
                        <span class="icon-holder"><i class="c-brown-500 ti-email"></i> </span>
                        <span class="title">Apps</span>
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
                    @yield('content')
                </div>
            </div>
        </main>
        <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
            <span>Copyright © 2017 Designed by <a href="http://www.mdcgate.com/apps/" target="_blank" title="">MDC</a>. All rights reserved.</span>
        </footer>
    </div>
</div>
<script src="/js/vendors/jquery.min.js"></script>
<script type="text/javascript" src="/js/dist/vendor.js"></script>
<script type="text/javascript" src="/js/dist/bundle.js"></script>
<script src="/js/vendors/lazyload.min.js"></script>
<script src="/js/dist/main.js"></script>
<script>
    let deleteOptions = {
        deleteUrl: "{!! $deleteUrlDetailPage ?? $deleteUrl ?? ""!!}",
        recordName: "{!! $recordNameDetailPage ?? $recordName ?? "" !!}",

    }
</script>
@yield('js')
</body>
</html>
