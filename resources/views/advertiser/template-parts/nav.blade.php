<nav class="uk-navbar-container uk-margin-small-bottom" style="background: #e1e1e1">
    <div class="uk-container uk-visible@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="{{ route('Public > Home') }}" target="_blank">
                            <img src="{{ asset('assets/static/images/Ronag-primary.png') }}" style="max-width: 100px; display: block" id="logo">
                            <span class="uk-hidden">{{ env('APP_NAME') }}</span>
                        </a>
                    </li>
                    <li><a href="{{ route('Advertiser > Profile') }}"><ion-icon name="person-circle-outline"></ion-icon> پروفایل</a></li>
                    <li><a href="{{ route('Advertiser > Form') }}"><ion-icon name="add-circle-outline"></ion-icon> ایجاد کسب و کار</a></li>
                    <li><a href="{{ route('Advertiser > Panel') }}"><ion-icon name="newspaper-outline"></ion-icon> مدیریت کسب و کار</a></li>
                </ul>

            </div>

            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="{{{ route('Auth > Logout') }}}" class="uk-link-reset">
                            <span uk-tooltip="خروج از حساب کاربری">
                                <ion-icon style="font-size: 25px" name="log-out" role="img" class="md hydrated"></ion-icon>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="uk-link-reset">
                            <button class="uk-button uk-button-muted uk-button-small uk-button-theme-primary">
                                <ion-icon name="person-outline" role="img" class="md hydrated"></ion-icon>
                                {{ Auth::user()->name }}
                            </button>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="uk-container uk-hidden@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="{{ route('Advertiser > Panel') }}">
                            <img src="{{ asset('assets/static/images/Ronag-primary.png') }}" style="max-width: 100px; display: block" id="logo">
                            <span class="uk-hidden">{{ env('APP_NAME') }}</span>
                        </a>
                    </li>

                    <li class="uk-active">
                        <a class="uk-text-bolder" uk-toggle="target: #responsive-menu">
                            <ion-icon style="color: #3A6F8D" name="menu"></ion-icon>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="uk-navbar-left">

                <ul class="uk-navbar-nav">
                    <li>
                        <a href="{{{ route('Auth > Logout') }}}" class="uk-link-reset">
                            <span uk-tooltip="خروج از حساب کاربری">
                                <ion-icon style="font-size: 25px" name="log-out"></ion-icon>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="uk-link-reset">
                            <button class="uk-button uk-button-muted uk-button-small uk-button-theme-primary">
                                <ion-icon name="person-outline"></ion-icon>
                                {{ Auth::user()->name }}
                            </button>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<div id="responsive-menu" uk-offcanvas="flip: true; overlay: true; mode: slide">
    <div class="uk-offcanvas-bar">

        <span class="uk-text-default uk-text-bold">منو</span>

        <div class="uk-text-center">
            <img src="{{ asset('assets/static/images/Ronag-primary.png') }}" style="max-width: 140px;" id="responsive-logo">
        </div>

        <div class="uk-divider uk-divider-icon"></div>
        <ul class="uk-nav uk-nav-primary uk-nav-right uk-margin-auto-vertical">
            <li class="uk-text-default"><a href="{{ route('Public > Home') }}" target="_blank"><ion-icon name="home-outline"></ion-icon> خانه</a></li>
            <li class="uk-text-default"><a href="{{ route('Advertiser > Profile') }}"><ion-icon name="person-circle-outline"></ion-icon> پروفایل</a></li>
            <li class="uk-text-default"><a href="{{ route('Advertiser > Form') }}"><ion-icon name="add-circle-outline"></ion-icon> ایجاد کسب و کار</a></li>
            <li class="uk-text-default"><a href="{{ route('Advertiser > Panel') }}"><ion-icon name="newspaper-outline"></ion-icon> مدیریت کسب و کار</a></li>
        </ul>

    </div>
</div>
