<div class="uk-container uk-hidden@m">
    <div uk-navbar="" class="uk-navbar uk-background-default uk-border-rounded">
        <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                <li class="uk-active">
                    <a class="uk-text-bolder" uk-toggle="target: #responsive-menu">
                        <img src="{{ asset('assets/static/images/logo.png') }}" style="max-width: 140px; display: block" id="logo">

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
                                <ion-icon style="font-size: 25px" name="log-out" role="img"
                                          class="md hydrated"></ion-icon>
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

<div id="responsive-menu" uk-offcanvas="flip: true; overlay: true; mode: slide">
    <div class="uk-offcanvas-bar">

        <span class="uk-text-default uk-text-bold">منو</span>

        <div class="uk-text-center">
            <img src="{{ asset('assets/static/images/logo.png') }}" style="max-width: 140px;" id="logo">
        </div>

        <div class="uk-divider uk-divider-icon"></div>
        <ul class="uk-nav uk-nav-primary uk-nav-right uk-margin-auto-vertical">
            <li>
                <a uk-tooltip="title: نمایش سایت; pos: left" href="{{ route('Public > Home') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block" target="_blank">
                    <span class="sidebar-item">
                        <ion-icon name="planet-outline"></ion-icon>
                    </span>
                    <span class="uk-text-meta">نمایش سایت</span>
                </a>
            </li>
            <li>
                <a uk-tooltip="title: داشبورد; pos: left" href="{{ route('Admin > Dashboard') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
                    <span class="sidebar-item" style="@if($routeName == 'Admin > Dashboard') color: #007bfd @endif">
                        <ion-icon
                            name="@if($routeName == 'Admin > Dashboard'){{ 'home' }}@else{{ 'home-outline' }}@endif"></ion-icon>
                    </span>
                    <span class="uk-text-meta">داشبورد</span>
                </a>
            </li>
            <li>
                <a uk-tooltip="title: مدیریت آگهی‌ها; pos: left" href="{{ route('Admin > Advertisements > Manage') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
                    <span class="sidebar-item"
                          style="@if($routeName == 'Admin > Advertisements > Manage') color: #007bfd @endif">
                        <ion-icon style="font-size: 25px"
                                  name="@if($routeName == 'Admin > Advertisements > Manage'){{ 'filter' }}@else{{ 'filter-outline' }}@endif"></ion-icon>
                    </span>
                    <span class="uk-text-meta">مدیریت آگهی‌ها</span>
                </a>
            </li>
            <li>
                <a uk-tooltip="title: مدیریت کاربران; pos: left" href="{{ route('Admin > Users > Manage') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
                    <span class="sidebar-item" style="@if($routeName == 'Admin > Users > Manage') color: #007bfd @endif">
                        <ion-icon style="font-size: 25px"
                                  name="@if($routeName == 'Admin > Users > Manage'){{ 'people' }}@else{{ 'people-outline' }}@endif"></ion-icon>
                    </span>
                    <span class="uk-text-meta">مدیریت کاربران</span>
                </a>
            </li>
            <li>
                <a uk-tooltip="title: تنظیمات سامانه; pos: left" href="{{ route('Admin > Settings > Manage') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
                    <span class="sidebar-item" style="@if($routeName == 'Admin > Settings > Manage') color: #007bfd @endif">
                        <ion-icon style="font-size: 25px"
                                  name="@if($routeName == 'Admin > Settings > Manage'){{ 'cog' }}@else{{ 'cog-outline' }}@endif"></ion-icon>
                    </span>
                </a>
                <span class="uk-text-meta">تنظیمات</span>
            </li>
            <li>
                <a uk-tooltip="title: خروج از حساب کاربری; pos: left" href="{{ route('Auth > Logout') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
                    <span class="sidebar-item">
                        <ion-icon style="font-size: 25px" name="log-out"></ion-icon>
                    </span>
                    <span class="uk-text-meta">خروج</span>
                </a>
            </li>
        </ul>

    </div>
</div>
