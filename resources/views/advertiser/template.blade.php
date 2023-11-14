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

    <link rel="stylesheet" href="{{ asset('assets/css/persian-datepicker.min.css') }}"/>
    <script src="{{ asset('assets/js/jquery-3.6.4.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/js/persian-datepicker.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/fonts/IRANYekanX/fontiran.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/IRANYekanX/style.css') }}">

    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, a, span, li, label, button, input, select, option, tr, th, td {
            font-family: IRANYekanX !important;
        }
        ion-icon {
            vertical-align: middle;
        }
    </style>
    @yield('tmp_head')
</head>
<body>
@include('advertiser.template-parts.nav')
@yield('content')
@yield('tmp_scripts')
<script src="{{ asset('assets/js/utils.js') }}"></script>
</body>
</html>
