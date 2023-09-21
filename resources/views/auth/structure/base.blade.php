<!doctype html>
<html lang="fa-IR" dir="RTL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" />
    <script src="{{ asset('assets/js/uikit.min.js') }}"></script>
    <script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/persian-datepicker.min.css') }}"/>
    <script src="{{ asset('assets/js/jquery-3.6.4.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/js/persian-datepicker.min.js') }}"></script>

    @yield('header')
    <script !src="">
        let appData = {
            locale: '{{ $currentLocale }}'
        };
        const AppLocale = '{{ $currentLocale }}';
    </script>
    <style>
        .ts-wrapper {
            min-height: 40px;
            height: fit-content !important;
        }
        .ts-control {
            border: none !important;
            width: 100% !important;
        }
        .focus .ts-control {
            box-shadow: unset !important;
        }
        @media(min-width: 1200px) {
            .uk-grid {
                margin-left: unset !important;
            }
        }
/*        .uk-grid {*/
/*            margin-left: unset !important;*/
/*            margin-right: unset !important;*/
/*        }*/
/*        .uk-grid>* {*/
/*            padding-left: unset !important;*/
/*        }*/
    </style>
</head>
<body>
    <main id="dashboard">
        <div uk-grid>
            @if(!in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['Auth > Login', 'Auth > Register', 'Auth > EmployerRegister']))
            <div id="sidebar" class="uk-width-1-6@m uk-visible@m uk-padding-remove">
                {{-- Sidebar elems holder --}}
                @include('app.private.jobseeker.structure.parts.sidebar')
            </div>
            @endif
            <div id="content" class="uk-width-expand@m">
                @yield('topbar')
                <div class="uk-padding">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    @include('auth.structure.parts.footer')
    @include('auth.structure.parts.scripts')
</body>
</html>
