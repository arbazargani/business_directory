@extends('advertiser.template')


@section('tmp_head')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link href="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.css" rel="stylesheet" type="text/css">

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

        th, td {
            text-align: right !important;
        }
    </style>
@endsection

@section('content')
    <div class="uk-container">
        <div class="uk-card uk-card-default uk-card-body">
            <h2 class="uk-card-title">تاریخچه کسب‌وکارهای شما</h2>
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-small uk-table-middle uk-table-divider">
                    <thead>
                    <tr>
                        <th>کد آگهی</th>
                        <th>عنوان کسب و کار</th>
                        <th class="uk-table-shrink">استان - شهر</th>
                        <th>وضعیت تایید</th>
                        <th>پکیج</th>
                        <th>وضعیت پرداخت</th>
                        <th>سطح آگهی</th>
                        <th>
                            @if(\Illuminate\Support\Facades\Request::has('sort') && \Illuminate\Support\Facades\Request::get('sort') == 'hits')
                                <a class="uk-link-reset" href="{{ route('Advertiser > Panel') }}">بازدید</a> @if(\Illuminate\Support\Facades\Request::has('sort')) <span uk-icon="triangle-down"></span> @endif
                            @else
                                <a href="{{ route('Advertiser > Panel') }}?sort=hits">بازدید</a>
                            @endif
                        </th>
                        <th class="uk-table-shrink">گروه شغلی</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($advertisements as $ad)
                        <tr>
                            <td>{{ Helper::faNum($ad->id) }}</td>
                            <td>
                                <span>{{ $ad->title }}</span>
                                <br>
                                <span class="uk-text-meta">ایجاد: {{ Helper::faNum(jdate($ad->created_at)->format('Y/m/d'))  }}</span>
                                @if(!is_null($ad->expires_at))
                                <br>
                                <span class="uk-text-meta uk-text-danger">انقضا: {{ Helper::faNum(jdate($ad->expires_at)->format('Y/m/d')) }}</span>
                                @endif
                            </td>
                            <td>{{{ "{$ad->province} - {$ad->city}" }}}</td>
                            <td>@if($ad->confirmed) <span class="uk-text-meta uk-text-success">تایید شده</span> @else <span class="uk-text-meta uk-text-warning">تایید نشده</span> @endif</td>
                            <td>@if(!is_null($ad->package_id)) <span class="uk-text-meta uk-text-success">{{ \App\Models\Package::find($ad->package_id)->name ?? '' }}</span> @else <span class="uk-text-meta">بدون پکیج</span> @endif</td>
                            <td>
                                @if(is_null($ad->transaction_id) || \App\Models\Transaction::find($ad->transaction_id)->paid !== 1)
                                    <a class="uk-link uk-link-toggle" href="{{ route('Advertiser > Advertisement > Pay Confirm', $ad->id) }}">
                                        <span class="uk-text-meta uk-text-danger">
                                            <ion-icon name="card-outline"></ion-icon>
                                            در انتظار پرداخت
                                        </span>
                                    </a>
                                @else
                                    @if(\App\Models\Transaction::find($ad->transaction_id)->paid == 1)
                                        <span class="uk-text-meta uk-text-success">
                                            <ion-icon name="card-outline"></ion-icon>
                                            پرداخت شده
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $ad->ad_level }}</td>
                            <td>{{ Helper::faNum($ad->hits) }}</td>
                            <td class="uk-text-meta">{{ $ad->getCategories() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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
@endsection
