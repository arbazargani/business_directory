<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>{{ env('APP_NAME') }} {{ $settings->where('name', 'page_title_seperator')->first()->value }} @yield('page_title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit-rtl.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}"/>
    <script src="{{ asset('assets/js/uikit.min.js') }}"></script>
    <script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>

    <!-- IonIcons JS -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/fonts/IRANYekanX/fontiran.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/IRANYekanX/style.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @yield('tmp_header')
    {!! !is_null($settings->where('name', 'before_closing_head_tag')->first()) ? $settings->where('name', 'before_closing_head_tag')->first()->value : null !!}
</head>
<body>

@include('public.template-parts.nav')
@yield('content')
@include('public.template-parts.footer')
@yield('tmp_scripts')
<script src="{{ asset('assets/js/utils.js') }}"></script>
<script src="{{ asset('assets/js/rating.js') }}"></script>
{!! !is_null($settings->where('name', 'before_closing_body_tag')->first()) ? $settings->where('name', 'before_closing_body_tag')->first()->value : null !!}
</body>
</html>
