<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}"/>
    <script src="{{ asset('assets/js/uikit.min.js') }}"></script>
    <script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>

    <link rel="preconnect" href="//fdn.fontcdn.ir">
    <link rel="preconnect" href="//v1.fontapi.ir">
    <link href="https://v1.fontapi.ir/css/Vazir" rel="stylesheet">
</head>
<body>

@include('public.template-parts.nav')
@yield('content')
@yield('tmp_scripts')
<script src="{{ asset('assets/js/utils.js') }}"></script>
</body>
</html>
