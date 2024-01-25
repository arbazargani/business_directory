<div class="uk-padding-small">
    <div style="border: 1px solid #dddddd" class="uk-card uk-card-default uk-card-small uk-card-body uk-border-rounded">
        @if($ad->ad_level !== 'basic' && json_decode($ad->business_images) !== null)
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="center: true">

            <ul class="uk-slider-items uk-grid">
                @foreach(json_decode($ad->business_images) as $img)
                    <li class="uk-width-3-4">
                        <div class="uk-panel">
                            <img class="uk-hidden" src="{{ asset("storage/$img") }}" alt="{{ "{$ad->title} در {$ad->city}" }}">
                            <div class="ad-card-slider-image" style="background: url('{{ asset("storage/$img") }}')"></div>
                            {{-- <div class="uk-position-center uk-panel"><h1>{{ $loop->iteration }}</h1></div> --}}
                        </div>
                    </li>
                @endforeach
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slider-item="next"></a>

        </div>
        <hr>
        @endif
        <h3 class="uk-card-title">
            <a href="{{ route('Public > Advertisement > Show', ['advertisement' => $ad->id, 'slug' => $ad->getSlug()]) }}" class="uk-link-reset">{{ $ad->title }}</a>
        </h3>
        <span class="uk-text-meta">دسته شغلی: {{ $ad->getCategories() }}</span>
        <br>
        <span class="uk-text-meta">ساعت کاری: {{ Helper::faNum(json_decode($ad->work_hours, true)[0]) }} - {{ Helper::faNum(json_decode($ad->work_hours, true)[1]) }}</span>
        <br>
        @if(is_array(json_decode($ad->off_days)) && count(json_decode($ad->off_days)) > 0)
            <span class="uk-text-meta">روزهای تعطیل:
                @foreach(json_decode($ad->off_days) as $od)
                {{ $translations['week_days'][$od] }} @if(!$loop->last) ،@endif
                @endforeach
            </span>
            <br>
        @endif
        <p>{{ mb_substr($ad->address, 0, 25) }} ...</p>
        @if($ad->ad_level == 'basic' && Route::current()->getName() == 'Public > Search')
            <div class="uk-text-center uk-border-rounded">
                <img class="uk-border-rounded" src="{{ asset('assets/static/images/ad-placeholder.png') }}">
            </div>
        @endif
    </div>
</div>
