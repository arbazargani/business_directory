<div class="uk-padding-small uk-padding-remove-horizontal">
    <div class="uk-background-muted uk-box-shadow-medium uk-width-small uk-margin-small uk-border-rounded uk-padding uk-text-center" style="height: 95vh; margin: auto 0; border: 1px solid #c2c2c23b">
        <a uk-tooltip="title: نمایش سایت; pos: left" href="{{ route('Public > Home') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block" target="_blank">
            <span class="sidebar-item">
                <ion-icon name="planet-outline"></ion-icon>
            </span>
        </a>

        <a uk-tooltip="title: داشبورد; pos: left" href="{{ route('Admin > Dashboard') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
            <span class="sidebar-item" style="@if($routeName == 'Admin > Dashboard') color: #007bfd @endif">
                <ion-icon name="@if($routeName == 'Admin > Dashboard'){{ 'home' }}@else{{ 'home-outline' }}@endif"></ion-icon>
            </span>
        </a>
        <a uk-tooltip="title: مدیریت آگهی‌ها; pos: left" href="{{ route('Admin > Advertisements > Manage') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
            <span class="sidebar-item" style="@if($routeName == 'Admin > Advertisements > Manage') color: #007bfd @endif">
                <ion-icon style="font-size: 25px" name="@if($routeName == 'Admin > Advertisements > Manage'){{ 'filter' }}@else{{ 'filter-outline' }}@endif"></ion-icon>
            </span>
        </a>
        <a uk-tooltip="title: مدیریت کاربران; pos: left" href="{{ route('Admin > Users > Manage') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
            <span class="sidebar-item" style="@if($routeName == 'Admin > Users > Manage') color: #007bfd @endif">
                <ion-icon style="font-size: 25px" name="@if($routeName == 'Admin > Users > Manage'){{ 'people' }}@else{{ 'people-outline' }}@endif"></ion-icon>
            </span>
        </a>
        <a uk-tooltip="title: تنظیمات سامانه; pos: left" href="{{ route('Admin > Settings > Manage') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
            <span class="sidebar-item" style="@if($routeName == 'Admin > Settings > Manage') color: #007bfd @endif">
                <ion-icon style="font-size: 25px" name="@if($routeName == 'Admin > Settings > Manage'){{ 'cog' }}@else{{ 'cog-outline' }}@endif"></ion-icon>
            </span>
        </a>
        <a uk-tooltip="title: خروج از حساب کاربری; pos: left" href="{{ route('Auth > Logout') }}" class="uk-link-reset uk-margin-small-bottom uk-display-inline-block">
            <span class="sidebar-item">
                <ion-icon style="font-size: 25px" name="log-out"></ion-icon>
            </span>
        </a>
    </div>
</div>
