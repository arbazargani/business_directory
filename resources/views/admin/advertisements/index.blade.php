@extends('admin.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - مدیریت آگهی‌ها' }}</title>
    <style>
        thead tr th {
            text-align: right !important;
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
                    <input type="text" class="uk-input" name="query" placeholder="جستجو در عنوان، شهر/استان، توضیحات، کاربر">
                </div>
                <div>
                    <button class="uk-button uk-button-primary">جستجو</button>
                </div>
            </div>
        </form>
    </div>
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-middle uk-table-divider">
            <thead>
            <tr>
                <th>کد آگهی</th>
                <th>کاربر</th>
                <th>تماس کاربر</th>
                <th>آخرین ورود کاربر</th>
                <th>عنوان کسب و کار</th>
                <th>استان - شهر</th>
                <th>وضعیت تایید</th>
                <th>سطح آگهی</th>
                <th>
                    @if(\Illuminate\Support\Facades\Request::has('sort') && \Illuminate\Support\Facades\Request::get('sort') == 'hits')
                        <a class="uk-link-reset" href="{{ route('Admin > Advertisements > Manage') }}">بازدید</a> @if(\Illuminate\Support\Facades\Request::has('sort')) <span uk-icon="triangle-down"></span> @endif
                    @else
                        <a href="{{ route('Admin > Advertisements > Manage') }}?sort=hits">بازدید</a>
                    @endif
                </th>
                <th>دسته‌بندی</th>
                <th>مدیریت</th>
            </tr>
            </thead>
            <tbody>
            @foreach($advertisements as $ad)
                <tr>
                    <td>{{ $ad->id }}</td>
                    <td class="hasActionButtons">
                        {{ $ad->user->name }}
                        <br>
                        <span class="uk-text-meta" onclick='window.open("{{ route('Admin > Users > Edit', ['id' => $ad->user->id]) }}", "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=900, height=900, top=30, left=30");'>
                            <ion-icon name="link"></ion-icon><span class="uk-text-meta">[id:{{ $ad->user->id }}]</span>
                        </span>
                    </td>
                    <td>{{ $ad->user->phone_number }}</td>
                    <td>{{ jdate($ad->user->updated_at)->format('Y/m/d-H:i:s') }}</td>
                    <td>{{ $ad->title }}</td>
                    <td>{{{ "{$ad->province} - {$ad->city}" }}}</td>
                    <td>@if($ad->confirmed) <span class="uk-text-success">تایید شده</span> @else <span class="uk-text-warning">تایید نشده</span> @endif</td>
                    <td>{{ $ad->ad_level }}</td>
                    <td>{{ $ad->hits }}</td>
                    <td>{{ $ad->getCategories() }}</td>
                    <td class="hasActionButtons">
                        <span uk-tooltip="پیش‌نمایش آگهی شماره {{ $ad->id }}" onclick='window.open("{{ route('Admin > Advertisements > Preview', ['id' => $ad->id]) }}", "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=1200, height=900, top=30, left=30");'>
                            <ion-icon style="font-size: 25px" name="barcode"></ion-icon>
                        </span>

                        <span uk-tooltip="مدیریت آگهی شماره {{ $ad->id }}" onclick="advertisementApprovlaOptIn({{ $ad->id }})">
                            <ion-icon style="font-size: 25px; color: dodgerblue" name="construct"></ion-icon>
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
