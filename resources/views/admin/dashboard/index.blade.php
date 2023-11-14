@extends('admin.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - داشبورد' }}</title>
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
    <h2>آمار کلی سامانه</h2>
    <hr>
    <ion-grid>
        <ion-row>
            <ion-col>
                <div class="uk-padding-large uk-box-shadow-small uk-border-rounded" style="background: #0064ff1c">
                    <span class="uk-text-lead">
                        <ion-icon name="people-outline"></ion-icon> تعداد کاربران
                    </span>
                    <span class="uk-float-left uk-text-lead uk-text-bolder">{{ $analytics_dataset['users_count'] }}</span>
                </div>
            </ion-col>
            <ion-col>
                <div class="uk-padding-large uk-box-shadow-small uk-border-rounded" style="background: #ff9b001c">
                    <span class="uk-text-lead">
                        <ion-icon name="file-tray-full-outline"></ion-icon> آگهی‌های امروز
                    </span>
                    <span class="uk-float-left uk-text-lead uk-text-bolder">{{ $analytics_dataset['today_ads'] }}</span>
                </div>
            </ion-col>
            <ion-col>
                <div class="uk-padding-large uk-box-shadow-small uk-border-rounded" style="background: #25ff001c;">
                    <span class="uk-text-lead">
                        <ion-icon name="file-tray-full-outline"></ion-icon> درآمد امروز
                    </span>
                    <span class="uk-float-left uk-text-lead uk-text-bolder uk-text-success">۱۲,۴۰۰,۰۰۰ ﷼</span>
                </div>
            </ion-col>
        </ion-row>
    </ion-grid>
    <hr>
    <div class="uk-card uk-card-body uk-card-default">
        <h2 class="uk-card-title"><ion-icon name="analytics"></ion-icon> برترین کسب‌وکارها <span class="uk-text-meta">[۸ روز اخیر | ۱۰ عدد | بروزرسانی ۳۰ دقیقه یکبار]</span></h2>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-small uk-table-middle uk-table-divider">
                <thead>
                <tr>
                    <th>کد آگهی</th>
                    <th>کاربر</th>
                    <th>عنوان کسب و کار</th>
                    <th>استان - شهر</th>
                    <th>سطح آگهی</th>
                    <th>بازدید</th>
                    <th>دسته‌بندی</th>
                </tr>
                </thead>
                <tbody>
                @foreach($analytics_dataset['top_8d_ads'] as $ad)
                    <tr>
                        <td>{{ $ad->id }}</td>
                        <td class="hasActionButtons">{{ $ad->user->name }}</td>
                        <td>{{ $ad->title }}</td>
                        <td>{{{ "{$ad->province} - {$ad->city}" }}}</td>
                        <td>{{ $ad->ad_level }}</td>
                        <td>{{ $ad->hits }}</td>
                        <td>{{ $ad->getCategories() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

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
    </div>
@endsection

@section('scripts')
@endsection
