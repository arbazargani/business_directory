@extends('admin.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - داشبورد' }}</title>
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
@endsection

@section('scripts')
@endsection
