<!doctype html>
<head lang="vi">
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #loader {
            transition: all .3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000
        }

        #loader.done {
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

    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet">
    @yield('css')


</head>
<body class="app ck-content">
<div id="loader">
    <div class="spinner"></div>
</div>

<script>
    window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function () {
            loader.classList.add('done');
        }, 300);
        $('img.lazyload').each(function () {
            $(this).attr('src', $(this).attr('data-src'));
        });
    });
</script>
<div>
    <div class="sidebar" style="background: #4f5f6f;">
        <div class="sidebar-inner">
            {{--            --}}{{--sidebar header--}}
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="{{route('admin.home')}}">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img src="/images/icon/logo2.png" alt="">
                                    </div>
                                </div>

                                <div class="peer peer-greed">
                                    <h5 class="logo-text">Adminator</h5>
                                </div>
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
                <li class="nav-item mT-30 {{request()->segment(2) == 'home'?'active':''}}">
                    <a class="sidebar-link" href="{{route('admin.home')}}">
                    <span class="icon-holder">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </span>
                        <span class="title" style="text-align: center">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item dropdown {{request()->segment(2) == 'livestreamplayer'?'active':''}}">

                    <a class="dropdown-toggle sidebar-link ">
                    <span class="icon-holder ">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </span>
                        <span class="title">Live Stream Player</span>
                        <span class="arrow">
                            <i class="ti-angle-right" aria-hidden="true"></i>
                        </span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="{{request()->segment(3)  == 'users'?'active':''}}">

                            <a class="sidebar-link" href="{{route('admin.livestreamplayer.users')}}">
                                <span class="title">Users</span>
                            </a>

                        </li>
                        <li class="{{request() -> segment(3)  == 'stream'?'active':''}}">

                            <a class="sidebar-link" href="{{route('admin.livestreamplayer.streams')}}">
                                <span class="title">Streams</span>
                            </a>

                        </li>
                        <li class="{{request() -> segment(3)  == 'message'?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.livestreamplayer.message')}}">
                                <span class="title ">Messages</span>
                            </a>

                        </li>
                        <li class="{{request() -> segment(3)  == 'analytic'?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.livestreamplayer.analytic')}}">
                                <span class="title">Analytics</span>
                            </a>

                        </li>

                    </ul>
                </li>

                <li class="nav-item dropdown {{request()->segment(2) == 'sales'?'active':''}}">
                    <a class="dropdown-toggle sidebar-link">
                        <span class="icon-holder ">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </span>
                        <span class="title">Sales</span>
                        <span class="arrow">
                            <i class="ti-angle-right" aria-hidden="true"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{request()->segment(3)  == 'order'?'active':''}}">

                            <a class="sidebar-link" href="{{route('admin.sales.order')}}">
                                <span class="title">Orders</span>
                            </a>

                        </li>
                        <li class="{{request() -> segment(3)  == 'subscription'?'active':''}}">

                            <a class="sidebar-link" href="{{route('admin.sales.subscription')}}">
                                <span class="title">Subscription</span>
                            </a>

                        </li>
                        <li class="{{request() -> segment(3)  == 'license'?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.sales.license')}}">
                                <span class="title">License</span>
                            </a>

                        </li>

                    </ul>

                </li>
                <li class="nav-item dropdown {{request() ->segment(2) == 'tools'? 'active':'' }}">
                    <a class="dropdown-toggle sidebar-link">
                                    <span class="icon-holder ">
                                       <i class="fa fa-home" aria-hidden="true"></i>
                                    </span>
                        <span class="title">Tools</span>
                        <span class="arrow">
                                            <i class="ti-angle-right" aria-hidden="true"></i>
                                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{request()->segment(3) == 'config'?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.config')}}">
                                <span class="title">Configs</span>
                            </a>

                        </li>
                        <li class="{{request()->segment(3) == 'sendBroadcast'?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.sendBroadcast')}}">
                                <span class="title">Send Broadcast</span>
                            </a>

                        </li>
                        <li class="{{request()->segment(3) == 'notification'?'active':''}}">
                            <a class="sidebar-link" href="{{route('admin.tools.notification')}}">
                                <span class="title">Notifications</span>
                            </a>

                        </li>
                        <li class="{{request()->segment(3) == 'testRule'?'active':''}}">

                            <a class="sidebar-link" href="{{route('admin.tools.testRule')}}">
                                <span class="title">Test Rules</span>
                            </a>

                        </li>

                    </ul>
                </li>

                <li class="nav-item {{request()->segment(2) == 'app'?'active':''}}">
                    <a class="sidebar-link" href="{{route('admin.app')}}">
                                    <span class="icon-holder">
                                       <i class="fa fa-home" aria-hidden="true"></i>
                                    </span>
                        <span class="title">Apps</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-container">
        <div class="header navbar">
            <div class="header-container zoom-90">
                <ul class="nav-left w-100 pr-3">
                    <li>
                        <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a>

                    </li>

                    <li class="float-right">
                        <a href="{{route('admin.logout')}}" style="font-size: 16px">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>

        <main class="main-content">
            <div id="mainContent">
                <div class="full-container bgc-grey-100">
                    @yield('content')
                    <footer class=" mt-4 bdT ta-c p-30 lh-0 fsz-sm bg-white zoom-90">
                        <span>
                            Copyright © 2019 Designed by MDC. All rights reserved.
                        </span>
                    </footer>
                </div>
            </div>
        </main>
    </div>

</div>

@include('layouts.script.jquery')
<script type="text/javascript" src="/js/admin/vendor.js"></script>
<script type="text/javascript" src="/js/admin/bundle.js"></script>
<script>
    $(document).ready(function(){
       $('#sidebar-toggle').click(function(){
           $('body').toggleClass('is-collapsed');
       }) ;
    });
</script>
@yield('script')

</body>
