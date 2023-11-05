<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.min.css') }}"/>
    <script src="{{ asset('assets/js/uikit.min.js') }}"></script>
    <script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="preconnect" href="//fdn.fontcdn.ir">
    <link rel="preconnect" href="//v1.fontapi.ir">
    <link href="https://v1.fontapi.ir/css/Vazir" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, a, span, li, label, button, input, select, option, tr, th, td {
            font-family: Vazir, sans-serif !important;
        }
        ion-icon {
            vertical-align: middle;
        }
    </style>
    @yield('tmp_head')
</head>
<body>

<nav class="uk-navbar-container uk-margin-small-bottom" style="background: #e1e1e1">
    <div class="uk-container uk-visible@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="{{ route('Public > Home') }}">
                            <img src="{{ asset('assets/static/images/logo.png') }}" style="width: 50px">
                            <span>{{ env('APP_NAME') }}</span>
                        </a>
                    </li>
                    <li><a href="{{ route('Advertiser > Panel') }}">مدیریت آکهی‌ها</a></li>
                    <li><a href="{{ route('Advertiser > Form') }}">ایجاد کسب و کار</a></li>
                </ul>

            </div>

            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li>
                        {{-- @todo: handle js function [logOutSession()] Bug --}}
                        <a href="{{{ route('Auth > Logout') }}}" class="uk-link-reset">
                            <span uk-tooltip="خروج از حساب کاربری">
                                <ion-icon style="font-size: 25px" name="log-out" role="img" class="md hydrated"></ion-icon>
                            </span>
                        </a href="">
                    </li>
                    <li>
                        <a href="" class="uk-link-reset">
                            <button class="uk-button uk-button-muted uk-button-small uk-button-theme-primary">
                                <ion-icon name="person-outline" role="img" class="md hydrated"></ion-icon>
                                {{ Auth::user()->name }}
                            </button>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="uk-container uk-hidden@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="https://jir-dd.iran.liara.run">
                            <span>{{ env('APP_NAME') }}</span>
                        </a>
                    </li>

                    <li class="uk-active">
                        <a class="uk-text-bolder" onclick="ToggleMobileNav()">
                            <ion-icon style="color: #3A6F8D" name="menu" role="img" class="md hydrated"></ion-icon>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="uk-navbar-left">

                <ul class="uk-navbar-nav">
                    <li>
                        <a href="" class="uk-link-reset">
                            <button class="uk-button uk-button-muted uk-button-small uk-button-theme-primary">
                                <ion-icon name="laptop-outline" role="img" class="md hydrated"></ion-icon>
                                ناحیه کاربری
                            </button>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
@yield('content')
@yield('tmp_scripts')
<script src="{{ asset('assets/js/utils.js') }}"></script>
</body>
</html>
