<nav class="uk-navbar-container uk-margin-small-bottom" style="background: {{ \Illuminate\Support\Facades\Cache::get('site_settings')->where('name', 'header_background_color')->first()->value }}">
    <div class="uk-container uk-visible@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="{{ Route('Public > Home') }}">
                            <img src="{{ asset('assets/static/images/Ronag-primary.png') }}" style="max-width: 100px" id="logo">
                            <h1 class="uk-text-default uk-margin-remove uk-hidden" style="vertical-align: middle">{{ env('APP_NAME') }}</h1>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Public > Home') }}">خانه</a>
                    </li>
                    <li>
                        <a href="#">خدمات</a>
                    </li>

                    <li>
                        <a href="#">درباره ما</a>
                    </li>

                    <li>
                        <a href="#">تماس با ما</a>
                    </li>

                    <li>
                        <a href="#">بلاگ</a>
                    </li>
                </ul>

            </div>

            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="{{ route('Public > Guest > AdAdvertisement') }}" class="uk-link-reset">
                            <ion-icon name="add-circle-outline" role="img" class="md hydrated"></ion-icon>
                            ثبت آگهی
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Auth > Login') }}" class="uk-link-reset">
                            <button class="uk-button uk-button-muted uk-button-small uk-button-theme-primary">
                                <ion-icon name="laptop-outline" role="img" class="md hydrated"></ion-icon>
                                ناحیه کاربری
                            </button>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    {{-- Responsive Nav --}}
    <div class="uk-container uk-hidden@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="{{ route('Public > Home') }}">
                            <img src="{{ asset('assets/static/images/Ronag-primary.png') }}" style="max-width: 100px" id="logo">
                            <span class="uk-hidden">{{ env('APP_NAME') }}</span>
                        </a>
                    </li>

                    <li class="uk-active">
                        <a class="uk-text-bolder" uk-toggle="target: #responsive-menu">
                            <ion-icon style="color: #3A6F8D;" name="menu"></ion-icon>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="uk-navbar-left">

                <ul class="uk-navbar-nav">
                    <li>
                        <a href="{{ route('Public > Guest > AdAdvertisement') }}" class="uk-link-reset">
                            <ion-icon name="add-circle-outline" role="img" class="md hydrated"></ion-icon>
                            ثبت آگهی
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Auth > Login') }}" class="uk-link-reset">
                            <button class="uk-button uk-button-muted uk-button-small uk-button-theme-primary">
                                <ion-icon name="laptop-outline" role="img" class="md hydrated"></ion-icon>
                                ناحیه کاربری
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
            <img src="{{ asset('assets/static/images/Ronag-primary.png') }}" style="max-width: 100px;" id="responsive-logo">
        </div>

        <div class="uk-divider uk-divider-icon"></div>

        <ul class="uk-nav uk-nav-primary uk-nav-right uk-margin-auto-vertical">
            <li class="uk-text-default"><a href="{{ route('Public > Home') }}">خانه</a></li>
            <li class="uk-text-default"><a href="#">خدمات</a></li>
            <li class="uk-text-default"><a href="#">درباره‌ی ما</a></li>
            <li class="uk-text-default"><a href="#">تماس</a></li>
            <li class="uk-text-default"><a href="#">بلاگ</a></li>
        </ul>

    </div>
</div>
