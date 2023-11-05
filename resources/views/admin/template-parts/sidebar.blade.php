<div class="uk-padding-small uk-padding-remove-horizontal">
    <div class="uk-background-muted uk-box-shadow-medium uk-width-small uk-margin-small uk-border-rounded uk-padding uk-text-center" style="height: 95vh; margin: auto 0; border: 1px solid #c2c2c23b">
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
    </div>

</div>
