@extends('auth.structure.base')

@section('header')
    <title>{{ env('APP_NAME') }} - ثبت‌نام</title>

    {{-- scoped style for auth component --}}
    <style>
        #action_button {
            margin: 2px -36px 0 2px;
        }

        .head-logo {
            max-width: 200px;
            /*margin-top: -30%;*/
        }
        form#registration-form input {
            width: 100%;
        }
        .policies-anchor {
            text-decoration: solid;
            text-decoration-color: #F1841B;
            font-weight: bolder;
        }
        .datepicker-plot-area {
            font-family: "IRANYekanX" !important;
        }
        .blink-border {
            border: 1px solid #9ae2ff;
            animation-name: blinking;
            animation-duration: 1s;
            animation-iteration-count: 100;
        }
        @keyframes blinking {
            50% {
                border-color: #ffcd5f;
            }
        }
    </style>
@endsection

@section('content')
    <div id="main-wrapper" class="uk-container uk-card uk-card-default uk-card-body uk-width-1-4@m">
        <div class="uk-text-center">
            <div style="min-height: 107px">
                <div class="uk-text-center">
                    <img class="head-logo" src="{{ asset('assets/static/images/logo.png') }}" alt="">
                </div>
            </div>

            <div class="uk-divider uk-divider-icon"></div>

            <div id="phone_verification_wrapper" class="uk-animation-fade">
                <p class="uk-text-default">برای ثبت‌نام شماره همراه خود را وارد نمایید.</p>
                <input id="phone_number" class="uk-width-2-3 uk-input uk-margin-small-bottom" type="text"
                       name="phone_number">
                <span id="action_button"
                      class="uk-icon uk-icon-button theme-primary-button theme-rounded-button uk-position-absolute"
                      uk-icon="icon: check" onclick="validateRegistrationNumber()"></span>
            </div>

            <form id="registration-form">
                <div id="registration-data-wrapper" class="uk-hidden uk-animation-fade uk-text-right uk-padding">
                    <div class="uk-alert-primary" uk-alert>
                        <p class="uk-text-default">درحال ثبت‌نام برای شماره <span id="phone_number_preview"></span> هستید.</p>
                    </div>
                    <input type="hidden" id="user_phone_number" name="phone_number">
                    <div class="uk-child-width-1-3@m" uk-grid>
                        <div class="uk-form-controls">
                            <label class="uk-width-1-1" for="user-full_name">نام و نام خانوادگی</label>
                            <hr class="mini-divider">
                            <input id="user-full_name" name="full_name" class="uk-width-2-3 uk-input" type="text"
                                   placeholder="نام و نام خانوادگی">
                        </div>
                        <div class="uk-form-controls">
                            <label class="uk-width-1-1" for="user-email">ایمیل</label>
                            <hr class="mini-divider">
                            <input id="user-email" name="email" class="uk-width-2-3 uk-input" type="email"
                                   placeholder="you@tld.com">
                        </div>
                        <div class="uk-form-controls">
                            <label for="user-gender">جنسیت</label>
                            <hr class="mini-divider">
                            <select id="user-gender" name="data[gender]" class="uk-select">
                                <option value="female">خانم</option>
                                <option value="male">آقا</option>
                            </select>
                        </div>
                        <div class="uk-form-controls">
                            <label for="birthdate">تاریخ تولد</label>
                            <hr class="mini-divider">
                            <input type="text" class="uk-input birthdate" placeholder="تاریخ تولد" id="mydate" name="data[birthdate]" autocomplete="off">
                        </div>
                    </div>

                    <div class="uk-child-width-1-1@m" uk-grid>
                        <div class="uk-form-controlls">
                            <span class="uk-text-meta"><a class="policies-anchor" href="#policies">قوانین و مقررات {{ env('APP_NAME') }}</a> را خوانده و با آن موافق هستم.</span>
                        </div>
                        <div class="uk-form-controlls">
                            <span class="uk-button theme-primary-button uk-button-large uk-width-1-1" onclick="handleRegistration()">ثبت اطلاعات</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // date picker
        $(document).ready(function() {
            $("#mydate").persianDatepicker({
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
