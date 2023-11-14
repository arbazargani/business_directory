@php
    $q = (\Illuminate\Support\Facades\Request::has('search_query'))
        ? \Illuminate\Support\Facades\Request::get('search_query')
        : null;
    $location = (\Illuminate\Support\Facades\Request::has('search_location'))
        ? (int) \Illuminate\Support\Facades\Request::get('search_location')
        : false;
@endphp
<div class="uk-section uk-margin-small-bottom" id="search-box-wrapper">
    <div class="uk-container uk-container-small">
        <h2 class="uk-text-lead uk-text-bold" id="search-box-title">جستجوی کسب و کارهای اطراف شما</h2>
        <form method="get" action="{{ route('Public > Search') }}">
            <div class="uk-child-width-1-1@s" uk-grid>
                <div class="uk-width-expand@m">
                    <input type="text" class="uk-input" name="search_query" placeholder="نام کسب و کار، خدمات و ..." value="{{ $q }}">
                    <span id="search-box-query-after" uk-icon="pencil"></span>
                </div>
                <div class="uk-width-medium@m">
                    <span id="search-box-location-before">در</span>
                    @include('globalComponents.provincesSelect', ['name' => 'search_location', 'id' => 'search-box-location', 'selected' => $location, 'hasAll' => true])
                    <span id="search-box-location-after" uk-icon="location"></span>
                </div>
                <div class="uk-width-auto@m">
                    <button class="uk-button theme-action-button theme-action-button-dark-text">
                        جستجو
                        <span class="uk-margin-small-right" uk-icon="search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
