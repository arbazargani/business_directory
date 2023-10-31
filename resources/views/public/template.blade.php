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

    <!-- IonIcons JS -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>

    <link rel="preconnect" href="//fdn.fontcdn.ir">
    <link rel="preconnect" href="//v1.fontapi.ir">
    <link href="https://v1.fontapi.ir/css/Vazir" rel="stylesheet">
    @yield('tmp_header')
</head>
<body>

@include('public.template-parts.nav')
@yield('content')
<div class="uk-margin-top uk-background-secondary uk-light uk-padding-small">
    <span>تمامی حقوق برای {{ env('APP_NAME') }} محفوظ است.</span>
</div>
@yield('tmp_scripts')
<script src="{{ asset('assets/js/utils.js') }}"></script>
</body>
</html>
