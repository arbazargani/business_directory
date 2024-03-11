<div class="uk-padding-small">
    <div class="uk-card uk-card-default uk-card-small uk-card-body uk-border-rounded commercial-card">
        <span class="uk-card-badge badge ad-card-popular-badge" uk-tooltip="کسب و کار محبوب">
            <ion-icon name="star"></ion-icon>
        </span>
        @if($ad->country_level_service)
        <span class="uk-card-badge badge ad-card-country-badge" uk-tooltip="سرویس‌دهی در سطح کشور">
            <ion-icon name="earth-outline"></ion-icon>
        </span>
        @endif
        @if($ad->ad_level !== 'basic')
            @if(!is_null($ad->business_images))
                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="center: true; ratio: 7:3; animation: fade">

                    <ul class="uk-slideshow-items uk-grid">
                        @foreach(json_decode($ad->business_images) as $img)
                            <li class="uk-width-1-1">
                                <img class="uk-hidden" src="{{ asset("storage/$img") }}" alt="{{ "{$ad->title} در {$ad->city}" }}">
                                <div class="ad-card-slider-image" style="background: url('{{ asset("storage/$img") }}')"></div>
                            </li>
                        @endforeach
                    </ul>

                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slideshow-next uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slideshow-previous uk-slideshow-item="next"></a>

                </div>
            @else
                <img class="uk-hidden" src="{{ asset("assets/static/images/ad-placeholder.png") }}" alt="{{ "{$ad->title} در {$ad->city}" }}">
                <div class="ad-card-slider-image" style="background: url('{{ asset("assets/static/images/ad-placeholder.png") }}')"></div>
            @endif
        <hr>
        @endif
        <h3 class="uk-card-title title">
            <a href="{{ route('Public > Advertisement > Show', ['advertisement' => $ad->id, 'slug' => $ad->getSlug()]) }}" class="uk-link-reset">{{ $ad->title }}</a>
        </h3>
        <span class="uk-text-meta meta">دسته شغلی: {{ $ad->getCategories() }}</span>
        <br>
        <span class="uk-text-meta meta">ساعت کاری: {{ Helper::faNum(json_decode($ad->work_hours, true)[0]) }} - {{ Helper::faNum(json_decode($ad->work_hours, true)[1]) }}</span>
        <br>
        @if(is_array(json_decode($ad->off_days)) && count(json_decode($ad->off_days)) > 0)
        <span class="uk-text-meta meta">روزهای تعطیل:
            @foreach(json_decode($ad->off_days) as $od)
    {{ $translations['week_days'][$od] }} @if(!$loop->last) ،@endif
@endforeach
        </span>
        <br>
        @endif
        <p class="address uk-text-truncate">{{ $ad->address }}</p>
        <a href="{{ route('Public > Advertisement > Show', ['advertisement' => $ad->id, 'slug' => $ad->getSlug()]) }}">
            <button class="uk-button uk-button-primary uk-width-1-1 cta-button"><ion-icon name="call"></ion-icon> نمایش اطلااعات تماس</button>
        </a>
    </div>
</div>
