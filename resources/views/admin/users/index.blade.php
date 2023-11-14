@extends('admin.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - مدیریت کاربران' }}</title>
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
    <h2 class="uk-card-title">کاربران ثبت‌نام شده</h2>
    <div class="uk-padding" id="filter-box">
        <form>
            <div uk-grid>
                <div class="uk-width-large@m">
                    <input type="text" class="uk-input" name="query" placeholder="جستجو در کد، نام، ایمیل، شماره تماس">
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
                <th>کد کاربر</th>
                <th>نام</th>
                <th>شماره تماس</th>
                <th>ایمیل</th>
                <th>آخرین ورود کاربر</th>
                <th>سایر اطلاعات</th>
                <th>تعداد آگهی‌ها</th>
                <th>آگهی‌های تایید شده</th>
                <th>آگهی‌های رد شده</th>
                <th>مدیریت</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                @php
                    $userAds = $user->advertisements;
                @endphp
                <tr>
                   <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>{{ $user->user_informations['birthdate'] }} - {{ $user->user_informations['gender'] }}</td>
                    <td>{{ $userAds->count() }}</td>
                    <td>{{ $userAds->where('confirmed', 1)->count() }}</td>
                    <td>{{ $userAds->where('confirmed', 0)->count() }}</td>
                    <td class="hasActionButtons">
                        <a uk-tooltip="مدیریت کاربر شماره {{ $user->id }}" class="uk-link-reset" href="{{ route('Admin > Users > Edit', ['user' => $user->id]) }}">
                            <ion-icon style="font-size: 25px; color: dodgerblue" name="construct"></ion-icon>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="uk-padding">
            {{ $users->links('vendor.pagination.simple-default') }}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
