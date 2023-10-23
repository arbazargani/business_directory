@extends('public.template')

@section('content')
    <div class="uk-container">
        <h2 class="uk-text-lead">کسب‌وکار های برتر</h2>
        <div class="uk-grid-small uk-child-width-1-3@m uk-grid-match" uk-grid>
            @foreach($advertisements['comercial'] as $ad)
                <div class="uk-padding-small">
                    <div style="border: 1px solid #dddddd" class="uk-card uk-card-default uk-card-body uk-border-rounded">
                        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="center: true">

                            <ul class="uk-slider-items uk-grid">
                                @foreach(json_decode($ad->business_images) as $img)
                                    <li class="uk-width-3-4">
                                        <div class="uk-panel">
                                            <img src="{{ asset("storage/$img") }}" width="400" height="600" alt="">
                                            <div class="uk-position-center uk-panel"><h1>{{ $loop->iteration }}</h1></div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slider-item="previous"></a>
                            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slider-item="next"></a>

                        </div>
                        <hr>
                        <h3 class="uk-card-title">{{ $ad->title }}</h3>
                        <span class="uk-text-meta">دسته شغلی: {{ json_decode($ad->business_categories) }}</span>
                        <br>
                        <span class="uk-text-meta">ساعت کاری: {{ json_decode($ad->work_hours, true)[0] }} - {{ json_decode($ad->work_hours, true)[1] }}</span>
                        <br>
                        @if(is_array(json_decode($ad->off_days)) && count(json_decode($ad->off_days)) > 0)
                            <span class="uk-text-meta">روزهای تعطیل: @foreach(json_decode($ad->off_days) as $od) {{ $translations['week_days'][$od] }}, @endforeach</span>
                            <br>
                        @endif
                        <p>{{ $ad->address }}</p>
                        @php $latlng = "{$ad->longitude},{$ad->latitude}"; @endphp
                        <a href="https://neshan.org/maps/@<?php echo $latlng ?>z"><span uk-icon="location"></span></a>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        <h2 class="uk-text-lead">کسب و کار های اخیر</h2>
        @foreach($advertisements['basic'] as $ad)
            <div class="uk-padding-small">
                <div style="border: 1px solid #dddddd" class="uk-card uk-card-default uk-card-body uk-border-rounded">
                    <h3 class="uk-card-title">{{ $ad->title }}</h3>
                    <span class="uk-text-meta">دسته شغلی: {{ json_decode($ad->business_categories) }}</span>
                    <br>
                    <span class="uk-text-meta">ساعت کاری: {{ json_decode($ad->work_hours, true)[0] }} - {{ json_decode($ad->work_hours, true)[1] }}</span>
                    <br>
                    @if(is_array(json_decode($ad->off_days)) && count(json_decode($ad->off_days)) > 0)
                        <span class="uk-text-meta">روزهای تعطیل: @foreach(json_decode($ad->off_days) as $od) {{ $translations['week_days'][$od] }}, @endforeach</span>
                        <br>
                    @endif
                    <p>
                        <a href="https://neshan.org/maps/@<?php echo $latlng ?>z"><span uk-icon="location"></span></a>
                        {{ $ad->address }}
                    </p>
                    @php $latlng = "{$ad->longitude},{$ad->latitude}"; @endphp
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('tmp_scripts')
@endsection
