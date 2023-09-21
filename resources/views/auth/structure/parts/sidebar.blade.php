<div>
    {{-- socket logo --}}
    <div class="socket uk-padding-small">
        <div class="uk-text-center">
            <a href="{{ route('Public > Home') }}" class="uk-link-reset">
                <img style="filter: brightness(100)" src="{{ asset('assets/static/images/logo.png') }}" width="121px" alt="">
            </a>
            <p><span class="uk-icon uk-margin-small-left"
                     uk-icon="clock"></span>{{ \Morilog\Jalali\Jalalian::forge('today')->format('%A, %d %B %Y'); }}
            </p>
        </div>
    </div>

    <div class="socket uk-padding-small uk-padding-remove-bottom uk-padding-remove-top">
        <div class="uk-border-rounded uk-padding-small @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'Panel > Dashboard') sidebar-active-socket @endif">
            <a href="#" class="uk-link-reset">
                                <span class="uk-text-default">
                                    <span class="uk-icon" uk-icon="icon: home; ratio: 1.2"></span>
                                    <span class="uk-padding-small">داشبورد</span>
                                </span>
            </a>
        </div>
    </div>

    <div class="socket uk-padding-small uk-padding-remove-bottom uk-padding-remove-top">
        <div class="uk-border-rounded uk-padding-small @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'Panel > Ads') sidebar-active-socket @endif">
            <a href="#" class="uk-link-reset">
                                <span class="uk-text-default">
                                    <span class="uk-icon" uk-icon="icon: album; ratio: 1.2"></span>
                                    <span class="uk-padding-small">آکهی‌های پیشنهادی</span>
                                </span>
            </a>
        </div>
    </div>

    <div class="socket uk-padding-small uk-padding-remove-bottom uk-padding-remove-top">
        <div class="uk-border-rounded uk-padding-small @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'Panel > Profile') sidebar-active-socket @endif">
            <a href="#" class="uk-link-reset">
                                <span class="uk-text-default">
                                    <span class="uk-icon" uk-icon="icon: user; ratio: 1.2"></span>
                                    <span class="uk-padding-small">پروفایل کاربری</span>
                                </span>
            </a>
        </div>
    </div>
</div>
