@extends('auth.structure.base')

@section('header')
    <title>{{ env('APP_NAME') }} - ورود</title>

    {{-- scoped style for auth component --}}
    <style>
        #action_button {
            margin: 2px -36px 0 2px;
        }
        .head-logo {
            max-width: 200px;
            /*margin-top: -30%;*/
        }
    </style>
@endsection

@section('content')
    <div id="main-wrapper" class="uk-container uk-card uk-card-default uk-card-body uk-width-1-4@m">
        <div class="uk-text-center">
            <div style="min-height: 107px">
                <div class="uk-text-center">
                    <img class="head-logo" src="{{ asset('assets/static/images/Ronag-primary.png') }}" alt="">
                </div>
            </div>

            <div class="uk-divider uk-divider-icon"></div>

            <div id="phone_verification_wrapper" class="uk-animation-fade">
                <p class="uk-text-default">برای ورود شماره همراه خود را وارد نمایید.</p>
                <input id="phone_number" class="uk-width-2-3 uk-input uk-margin-small-bottom" type="text" name="phone_number">
                <span id="action_button" class="uk-icon uk-icon-button theme-primary-button theme-rounded-button uk-position-absolute" uk-icon="icon: check" onclick="handleMobileAuth()"></span>
                <hr>
                <a class="uk-display-block uk-link-reset uk-text-meta" href="{{ route('Auth > Register') }}">ثبت نام</a>
            </div>

            <div id="otp_entry_wrapper" class="uk-hidden uk-animation-fade">
                <p class="uk-text-default">رمز یکبارمصرف را وارد نمایید.</p>
                <input type="hidden" id="user_phone_number">
                <input id="otp" class="uk-width-2-3 uk-input uk-margin-small-bottom" type="text" name="otp">
                <span id="action_button" class="uk-icon uk-icon-button theme-primary-button theme-rounded-button uk-position-absolute" uk-icon="icon: arrow-right" onclick="checkUserOtp()"></span>

                <div class="uk-text-center" id="timer-wrapper">
                    <span class="uk-text-meta">
                        برای درخواست دوباره رمز <span id="timer"></span> صبر کنید.
                    </span>
                </div>
                <div class="uk-text-center uk-hidden" id="resend-otp">
                    <a class="uk-text-meta uk-link-reset" onclick="resendOtp()">ارسال دوباره رمز</a>
                </div>
            </div>
        </div>
    </div>

@endsection
