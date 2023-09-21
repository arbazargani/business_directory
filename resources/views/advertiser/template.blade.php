<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.min.css') }}"/>
    <script src="{{ asset('assets/js/uikit.min.js') }}"></script>
    <script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>

    <link rel="preconnect" href="//fdn.fontcdn.ir">
    <link rel="preconnect" href="//v1.fontapi.ir">
    <link href="https://v1.fontapi.ir/css/Vazir" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, a, span, li, label, button, input, select {
            font-family: Vazir, sans-serif !important;
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
                        <a class="uk-text-bolder" href="https://jir-dd.iran.liara.run">
                            <img src="https://avatars.githubusercontent.com/u/61144196?s=48&v=4" style="width: 50px">
                        </a>
                    </li>
                    <li>
                        <a href="#" role="button" aria-haspopup="true">آگهی‌ها<span uk-navbar-parent-icon="" class="uk-icon uk-navbar-parent-icon"><svg width="12" height="12" viewBox="0 0 12 12"><polyline fill="none" stroke="#000" stroke-width="1.1" points="1 3.5 6 8.5 11 3.5"></polyline></svg></span></a>
                        <div class="uk-navbar-dropdown uk-box-shadow-large uk-border-rounded uk-drop">
                            <div class="">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="">ایجاد کسب و کار</a></li>
                                    <li><a href="">مدیریت آکهی‌ها</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>

            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="https://jir-dd.iran.liara.run/app/auth/login" class="uk-link-reset">
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
    <div class="uk-container uk-hidden@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="https://jir-dd.iran.liara.run">
                            <img class="nav-logo" src="https://jir-dd.iran.liara.run/assets/static/images/logo.png" alt="">
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
                        <a href="https://jir-dd.iran.liara.run/app/auth/login" class="uk-link-reset">
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
