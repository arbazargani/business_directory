@extends('advertiser.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - بروزرسانی پروفایل' }}</title>
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
    <div class="uk-container">
        <div class="uk-card uk-card-default uk-card-body">
            <h2 class="uk-card-title">ویرایش پروفایل <span class="uk-text-meta">id: {{ $user->id }} - {{ $user->name }}</span></h2>
            @if($errors->any())
                @foreach($errors->all() as $err)
                    <p class="uk-text-danger">{{ $err }}</p>
                @endforeach
            @endif
            <form class="uk-form-stacked" method="post">
                @csrf
                <div class="uk-child-width-1-3@m" uk-grid>
                    <!--  Full name -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="name">نام و نام خانوادگی</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="name" name="name" type="text" value="{{ $user->name }}">
                            </div>
                        </div>
                    </div>
                    <!--  Phone number -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="phone_number">شماره تلفن</label>
                            <div class="uk-form-controls">
                                <input class="uk-input uk-disabled" id="phone_number" name="phone_number" type="text" value="{{ $user->phone_number }}" disabled>
                                <span class="uk-text-danger uk-text-warning">شماره همراه قابل تغییر نمی‌باشد.</span>
                            </div>
                        </div>
                    </div>
                    <!--  Phone number -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="email">ایمیل</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="email" name="email" type="email" value="{{ $user->email }}">
                            </div>
                        </div>
                    </div>
                    <!--  Password -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="password">رمز عبور</label>
                            <div class="uk-form-controls">
                                <input class="uk-input uk-form-warning" id="password" name="password" type="text">
                                <span class="uk-text-warning uk-text-meta uk-text-bolder">تنها در صورت نیاز به تغییر رمز پر کنید.</span>
                            </div>
                        </div>
                    </div>
                    <!--  Password confirm -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="password_confirmation">تکرار رمز عبور</label>
                            <div class="uk-form-controls">
                                <input class="uk-input uk-form-warning" id="password_confirmation" name="password_confirmation" type="text">
                                <span class="uk-text-warning uk-text-meta uk-text-bolder">تنها در صورت نیاز به تغییر رمز پر کنید.</span>
                            </div>
                        </div>
                    </div>

                    <!--  Gender -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="gender">جنسیت</label>
                            <div class="uk-form-controls">
                                <select class="uk-select" name="gender">
                                    <option value="female" @if($user->user_informations['gender'] == 'female') selected @endif>خانم</option>
                                    <option value="male" @if($user->user_informations['gender'] == 'male') selected @endif>آقا</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--  Birthdate -->
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="birthdate">تاریخ تولد</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="birthdate" name="birthdate" type="text" value="{{ jdate($user->user_informations['birthdate'])->format("Y/m/d") }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <!--  Save button -->
                    <div>
                        <div class="uk-margin">
                            <br>
                            <button class="uk-button uk-button-primary uk-width-1-1" type="submit">بروزرسانی</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('tmp_scripts')
    <script>
        // date picker
        $(document).ready(function() {
            $("#birthdate").persianDatepicker({
                altField: '#mydate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                initialValue: false,
                initialValueType: 'persian',
                autoClose: true,
                maxDate: 'today',
                responsive: true,
                navigator: {
                    text: {
                        btnNextText: "<",
                        btnPrevText: ">"
                    }
                }
            });
        });
    </script>
@endsection
