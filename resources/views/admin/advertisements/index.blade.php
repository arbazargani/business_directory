@extends('admin.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - مدیریت آگهی‌ها' }}</title>
    <style>
        thead tr th {
            text-align: right !important;
        }
        tr:hover {
            border: 1px solid rgba(220, 20, 60, 0.2);
            cursor: pointer;
        }
        .pagination {
            text-align: center !important;
        }
        .pagination li {
            display: inline-block;
            margin: auto 1%;
        }
        .hasActionButtons span:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h2 class="uk-card-title">کسب و کارهای ثبت شده</h2>
    <div class="uk-padding" id="filter-box">
        <form>
            <div uk-grid>
                <div class="uk-width-large@m">
                    <input type="text" class="uk-input" name="query" placeholder="جستجو در عنوان، شهر/استان، توضیحات، کاربر، گروه شغلی">
                </div>
                <div>
                    <button class="uk-button uk-button-primary">جستجو</button>
                </div>
            </div>
        </form>
    </div>
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover">
            <thead>
            <tr>
                <th>کد آگهی</th>
                <th>کاربر</th>
                <th>تماس کاربر</th>
                <th>آخرین ورود کاربر</th>
                <th>عنوان کسب و کار</th>
                <th class="uk-table-shrink">استان - شهر</th>
                <th>وضعیت تایید</th>
                <th>پکیج</th>
                <th>وضعیت پرداخت</th>
                <th>سطح آگهی</th>
                <th>
                    @if(\Illuminate\Support\Facades\Request::has('sort') && \Illuminate\Support\Facades\Request::get('sort') == 'hits')
                        <a class="uk-link-reset" href="{{ route('Admin > Advertisements > Manage') }}">بازدید</a> @if(\Illuminate\Support\Facades\Request::has('sort')) <span uk-icon="triangle-down"></span> @endif
                    @else
                        <a href="{{ route('Admin > Advertisements > Manage') }}?sort=hits">بازدید</a>
                    @endif
                </th>
                <th class="uk-table-shrink">گروه شغلی</th>
                <th>مدیریت</th>
            </tr>
            </thead>
            <tbody>
            @foreach($advertisements as $ad)
                <tr @if(!is_null($ad->transaction_id)) style="background: rgba(144,238,144,0.23)" @endif>
                    <td class="uk-text-meta">{{ $ad->id }}</td>
                    <td class="uk-text-meta" class="hasActionButtons">
                        {{ $ad->user->name }}
                        <br>
                        <span class="uk-text-meta" onclick='window.open("{{ route('Admin > Users > Edit', ['user' => $ad->user->id]) }}?sidebarless=true", "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=900, height=900, top=30, left=30");'>
                            <ion-icon name="link"></ion-icon><span class="uk-text-meta">[id:{{ $ad->user->id }}]</span>
                        </span>
                    </td>
                    <td class="uk-text-meta">{{ $ad->user->phone_number }}</td>
                    <td class="uk-text-meta">{{ jdate($ad->user->updated_at)->format('Y/m/d-H:i:s') }}</td>
                    <td class="uk-text-meta">{{ $ad->title }}</td>
                    <td class="uk-text-meta">{{{ "{$ad->province} - {$ad->city}" }}}</td>
                    <td class="uk-text-meta">@if($ad->confirmed) <span class="uk-text-success">تایید شده</span> @else <span class="uk-text-warning">تایید نشده</span> @endif</td>
                    <td class="uk-text-meta">@if(!is_null($ad->transaction_id)) <span class="uk-text-meta uk-text-success">{{ \App\Models\Transaction::find($ad->transaction_id)->package->name }}</span> @else <span class="uk-text-meta">بدون پکیج</span> @endif</td>
                    <td class="uk-text-meta">
                        @if(!is_null($ad->transaction_id))
                            @if(\App\Models\Transaction::find($ad->transaction_id)->paid) <span class="uk-text-meta uk-text-success">پرداخت شده</span> @else <span class="uk-text-meta uk-text-danger">پرداخت نشده</span> @endif
                        @else
                            <span class="uk-text-meta uk-text-warning">در انتظار پرداخت</span>
                        @endif
                    </td>
                    <td class="uk-text-meta">{{ $ad->ad_level }}</td>
                    <td class="uk-text-meta">{{ $ad->hits }}</td>
                    <td class="uk-text-meta">{{ $ad->getCategories() }}</td>
                    <td class="uk-text-meta" class="hasActionButtons">
                        <span uk-tooltip="پیش‌نمایش آگهی شماره {{ $ad->id }}" onclick='window.open("{{ route('Admin > Advertisements > Preview', ['id' => $ad->id]) }}", "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=1200, height=900, top=30, left=30");'>
                            <ion-icon style="font-size: 25px" name="barcode"></ion-icon>
                        </span>

                        <span uk-tooltip="@if(is_null($ad->transaction_id)) آگهی پرداخت نشده **** @endif مدیریت آگهی شماره {{ $ad->id }}" onclick="advertisementApprovlaOptIn({{ $ad->id }})">
                            <ion-icon style="font-size: 25px; color: @if(is_null($ad->transaction_id)) red @else dodgerblue @endif" name="construct"></ion-icon>
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="uk-padding">
            {{ $advertisements->links('vendor.pagination.simple-default') }}
        </div>

        <!-- This is a button toggling the modal -->
        <button uk-toggle="target: #advertisement_approval_modal" type="button"></button>

        <!-- This is the modal -->
        <div id="advertisement_approval_modal" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title">مدیریت آگهی</h2>
                <p>آیا آگهی مورد تایید می‌باشد؟</p>
                <p class="uk-text-right">
                    <button onclick="changeAdConfirmedStat(false)" class="uk-button uk-button-danger" type="button">خیر</button>
                    <button onclick="changeAdConfirmedStat(true)" class="uk-button uk-button-primary" type="button">بله</button>
                </p>
            </div>
            <form id="adConfirmationForm" action="{{ route('Admin > Advertisements > Manage') }}" method="POST">
                @csrf
                <input type="hidden" name="ad_id" id="advertisementApprovlaOptIn_id">
                <input type="hidden" name="ad_confirmed" id="advertisementApprovlaOptIn_confirmed">

            </form>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
