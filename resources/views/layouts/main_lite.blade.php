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
    @yield('content')
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
