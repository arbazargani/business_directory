<nav class="uk-navbar-container uk-margin-small-bottom" style="background: #e1e1e1">
    <div class="uk-container uk-visible@m">
        <div uk-navbar="" class="uk-navbar">

            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a class="uk-text-bolder" href="#">
                            <img src="{{ asset('assets/static/images/logo.png') }}" style="width: 50px" id="logo">
                            <h1 class="uk-text-default uk-margin-remove" style="vertical-align: middle">{{ env('APP_NAME') }}</h1>
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
                        <a class="uk-text-bolder" href="https://jir-dd.iran.liara.run">
                            <span>{{ env('APP_NAME') }}</span>
                        </a>
                    </li>

                    <li class="uk-active">
                        <a class="uk-text-bolder" onclick="ToggleMobileNav()">
                            <ion-icon style="color: #3A6F8D" name="menu" role="img" class="md hydrated"></ion-icon>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="uk-navbar-left">

                <ul class="uk-navbar-nav">
                    <li>
                        <a href="" class="uk-link-reset">
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
