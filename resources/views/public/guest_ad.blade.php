@extends('public.template')

@section('page_title')
    افزودن آگهی
@endsection

@section('tmp_header')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.css" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <style>
        .uk-grid {
            margin-right: -15px !important;
        }
        .uk-card-default {
            /*background: #262626;*/
        }
        #map {
            height: 500px;
            width: 100%;
        }
        .uk-input-dark {
            /* background-color: #383838;
            border: none;
            border-radius: 100px;
            color: #c4c4c4; */
        }

        .uk-input-dark:focus {
            /* background-color: #383838;
            border: none;
            border-radius: 100px;
            color: #c4c4c4; */
        }

        .uk-button-dark {
            /* background-color: #520085;
            border: none;
            border-radius: 100px;
            color: #c4c4c4;
            font-weight: 900; */
        }
        #results {
            max-height: 300px;
            overflow-x: auto;
        }

        #step-tabset {
            display: inline-block;
            overflow: auto;
            overflow-y: hidden;
            max-width: 100%;
            white-space: nowrap;
            padding: 7px;
            scroll-behavior: smooth;
        }

        #step-tabset li {
            display: inline-block;
            vertical-align: top;
        }

        .ts-control {
            border: unset !important;
        }

        .file_prev {
            max-width: 200px;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="uk-container uk-margin-medium-top">
        <input type="hidden" name="includes_registration" id="includes_registration" value="true">
        @include('advertiser.panel.advertisement_form')
    </div>
@endsection

@section('tmp_scripts')
    <script src="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.css"/>
    <script src="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.js"></script>
    <script src="{{ asset('assets/js/neshan.js') }}"></script>
    <script>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        UIkit.notification('{{ $error }}');
        @endforeach
        @endif

        @if(isset($message))
        UIkit.notification('{{ $message }}');
        @endif
    </script>

    <script>
        var offDaysConfig = {
            plugins: {
                remove_button: {
                    title: 'حذف',
                }
            },
            placeholder: 'روزهای تعطیل'
        };
        new TomSelect('#off_days',offDaysConfig);

        var jobCategoryConfig = {
            placeholder: 'انتخاب گروه شغلی'
        };
        new TomSelect('#business_category',jobCategoryConfig);
    </script>
@endsection
