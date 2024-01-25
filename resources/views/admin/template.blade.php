@php
    $routeName = \Request::route()->getName();
@endphp
<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.17.8/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.17.8/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.17.8/dist/js/uikit-icons.min.js"></script>

    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />

    <link rel="stylesheet" href="{{ asset('assets/fonts/IRANYekanX/fontiran.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/IRANYekanX/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/persian-datepicker.min.css') }}"/>
    <script src="{{ asset('assets/js/jquery-3.6.4.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/js/persian-datepicker.min.js') }}"></script>

    <style>
        body {
            background: #bebebe;
            min-height: 100vh;
        }

        ion-content {
            background: #ffffffe8 !important;
        }

        p, h1, h2, h3, h4, h5, h6, a, span, li, label, button, input, select, option, tr, th, td {
            font-family: IRANYekanX, sans-serif !important;
        }
        ion-icon {
            vertical-align: middle;
        }
        .sidebar-item {
            display: inline-block;
            width: 35px;
            height: 35px;
            padding: 3px;
            margin: 2% 0;
            border-radius: 5px;
            font-size: 20px;
            background: #0012ff0d;
        }
    </style>

    @yield('head')
</head>
<body>
    <ion-grid>
        <ion-row>
            @if(!isset($_GET['sidebarless']))
            <ion-col class="uk-visible@s" size-sm="12" size-md="1">
                <div class="" id="sidebar">
                    @include('admin.template-parts.sidebar')
                </div>
            </ion-col>
            @endif
            <ion-col class="uk-width-expand@m" size-sm="12" size-md="11">
                @include('admin.template-parts.nav')
                <div class="uk-padding-small" id="content">
                    <div class="uk-card uk-card-default uk-card-body uk-border-rounded" style="height: 96vh;">
                        <ion-content>
                        @yield('content')
                        </ion-content>
                    </div>
                </div>
            </ion-col>
        </ion-row>
    </ion-grid>
    @yield('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    @include('admin.template-parts.scripts')
</body>
</html>
