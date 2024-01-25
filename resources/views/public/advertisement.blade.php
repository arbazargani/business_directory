@extends('public.template')

@section('page_title')
    {{ $ad->title }}
@endsection

@section('tmp_header')
    <style>
        .info-item::before {
            content:"\A";
            width:5px;
            height:5px;
            border-radius:50%;
            display:inline-block;
            margin-left: 5px;
            vertical-align: middle;
            background: var(--theme-action-color);
        }
        #rating-container {
            direction: ltr;
            text-align: right;
            background: var(--theme-secondary-color) !important;
        }

        #rating-container .title {
            direction: rtl !important;
            color: white;
            font-weight: bold;
        }

        #rating-container .rating-star {
            cursor: pointer;
            font-size: 1.4rem !important;
        }
        .rating-star:hover {
            color: var(--theme-action-color);
        }
    </style>
@endsection

@section('content')
    <div class="uk-container uk-margin-medium-top">
        <ion-grid>
            <ion-row>
                <ion-col size="12" size-md="6" size-lg="6">
                    <div class="detail-container">
                        <div class="">
                            <div class="uk-card uk-card-default uk-card-body">
                                <h2 class="info-item uk-text-lead">{{ $ad->title }}</h2>
                                @if(json_decode($ad->business_images) !== null)
                                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="center: true">

                                    <ul class="uk-slider-items uk-grid">
                                        @foreach(json_decode($ad->business_images) as $img)
                                            <li class="uk-width-1-1">
                                                <div class="uk-panel">
                                                    <div class="ad-card-slider-image-large uk-border-rounded" style="background: url('{{ asset("storage/$img") }}')"></div>
                                                    {{--                                    <div class="uk-position-center uk-panel"><h1>{{ $loop->iteration }}</h1></div>--}}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" style="background: #00000033; padding: 7px 10px; border-radius: 3px" href uk-slidenav-next uk-slider-item="previous"></a>
                                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" style="background: #00000033; padding: 7px 10px; border-radius: 3px" href uk-slidenav-previous uk-slider-item="next"></a>
                                </div>
                                @endif
                                @if(strlen($ad->desc) > 0)
                                    <div class="uk-card uk-card-body uk-card-muted uk-box-shadow-medium uk-margin-medium-top uk-border-rounded" style="background: #00000014; border-right: 5px solid var(--theme-secondary-color)">
                                        <h3 style="font-size: 20px; font-weight: 900">درباره‌ی {{ $ad->business_name }}</h3>
                                        <p>{{ $ad->desc }}</p>
                                    </div>
                                @else
                                    <div class="uk-padding-small uk-margin-small-top">
                                        <span class="uk-text-warning">توضیحات ثبت نشده است.</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </ion-col>

                <ion-col size="12" size-md="6" size-lg="6">
                    <div id="map-container">
                        <div class="">
                            <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-border-rounded">
                                <div class="uk-border-rounded uk-width-expand" id="map" style="min-height: 500px"></div>
                                <input type="hidden" id="lat">
                                <input type="hidden" id="lng">
                                <div class="uk-padding">
                                    <span class="info-item uk-text-meta"><span class="uk-text-bolder">استان:</span> {{ $ad->province }}</span>
                                    <br>
                                    <span class="info-item uk-text-meta"><span class="uk-text-bolder">شهر:</span> {{ $ad->city }}</span>
                                    <br>
                                    <span class="info-item uk-text-meta"><span class="uk-text-bolder">دسته شغلی:</span> {{ json_decode($ad->business_categories) }}</span>
                                    <br>
                                    <span class="info-item uk-text-meta"><span class="uk-text-bolder">ساعت کاری:</span> {{ json_decode($ad->work_hours, true)[0] }} - {{ json_decode($ad->work_hours, true)[1] }}</span>
                                    <br>
                                    @if(is_array(json_decode($ad->off_days)) && count(json_decode($ad->off_days)) > 0)
                                        <span class="info-item uk-text-meta"><span class="uk-text-bolder">روزهای تعطیل:</span>
                                        @foreach(json_decode($ad->off_days) as $od)
                                            {{ $translations['week_days'][$od] }} @if(!$loop->last) ،@endif
                                        @endforeach
                                        </span>
                                        <br>
                                    @endif
                                    <button id="mobile_ad_phone_prev" class="uk-margin uk-button uk-button-small uk-hidden" style="background: var(--theme-secondary-color); color: #ffffff; font-weight: 900">
                                        <a href="tel:{{ $ad->phone }}" class="uk-link-reset">
                                            <ion-icon style="vertical-align: middle" name="call-outline"></ion-icon>
                                            شماره تماس
                                        </a>
                                    </button>
                                    <span id="desktop_ad_phone_prev" class="uk-text-meta uk-hidden">
                                        <span class="info-item uk-text-bolder">شماره تماس: </span>
                                        {{ $ad->phone }}
                                    </span>
                                    <br/>
                                    <span class="info-item uk-text-bolder">آدرس:</span> {{ $ad->address }}
                                    @include('public.template-parts.components.rating', ['ad' => $ad])
                                </div>
                            </div>
                        </div>
                    </div>
                </ion-col>
            </ion-row>
        </ion-grid>
        <div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
            <h3 class="uk-text-default uk-text-bold"><ion-icon name="caret-back-outline"></ion-icon> کسب و کار های مرتبط</h3>
            <ion-grid>
                <ion-row>
                    @forelse($related_ads as $related)
                        <ion-col size="12" size-md="4" size-lg="4">
                            @include('public.template-parts.components.adcardMinimal', ['ad' => $related])
                        </ion-col>
                    @empty
                        <div class="uk-alert-warning uk-alert" uk-alert="">
                            <p>متاسفانه کسب و کار مشابهی در دسترس نمی‌باشد.</p>
                        </div>
                    @endforelse
                </ion-row>
            </ion-grid>
        </div>
        <div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
            <h3 class="uk-text-default uk-text-bold"><ion-icon name="caret-back-outline"></ion-icon> نظرات در مورد {{ $ad->business_name }}</h3>
            @forelse($comments as $comment)
                <div class="uk-padding-small uk-margin-small-top comment-item" style="background: #00000014; border-right: 5px solid var(--theme-action-color)">
                    <span class="uk-text-meta">ارسال شده در {{ jdate($comment->created_at)->format('l d F Y') }}</span>
                    <p>{{ $comment->content }}</p>
                </div>
            @empty
                <div class="uk-padding-small uk-margin-small-top">
                    <div class="uk-alert-warning" uk-alert>
                        <p>نظری ثبت نشده است.</p>
                    </div>
                </div>
            @endforelse

            <hr>
            <div class="uk-card uk-card-secondary uk-card-body uk-border-rounded">
                <h4>افزودن نظر</h4>
                <hr>
                <form method="post" action="{{ route('Public > Advertisement > Comment', ['ad_id' => $ad->id]) }}">
                    @csrf
                    <div uk-grid>
                        <div class="uk-width-2-3@m">
                            <textarea name="comment_content" placeholder="نظر خود را وارد نمایید." class="uk-textarea uk-border-rounded" style="width: 100%" rows="5"></textarea>
                        </div>
                        <div class="uk-width-1-3@m">
                            <span class="info-item uk-text-meta">نظر شما پس تایید ادمین نمایش داده خواهد شد.</span>
                            <br>
                            <span class="info-item uk-text-meta">نظرات نامناسب بصورت خودکار حذف خواهند شد.</span>
                            <br>
                            <span class="info-item uk-text-meta">قوانین ثبت نظر را خوانده و با آن موافقم.</span>
                            <br>
                            <br>
                            <button class="uk-button theme-action-button theme-action-button-dark-text uk-width-1-1">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                ثبت نظر
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('tmp_scripts')
    <script src="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.css"/>
    <script src="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.js"></script>
    <script src="{{ asset('assets/js/neshan.js') }}"></script>
    <script>
        changeView([{{ $ad->latitude }}, {{ $ad->longitude }}], 14, true);
        map.removeEventListener('click');

        @if ($errors->any())
        @foreach ($errors->all() as $error)
            UIkit.notification('{{ $error }}');
        @endforeach
        @endif

        @if(isset($message))
        UIkit.notification('{{ $message }}');
        @endif
    </script>

    <script>
        function isMobile() {
            let is_mobile = false;
            if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)
                || navigator.userAgent.match(/iPad/i)
                || navigator.userAgent.match(/iPod/i)
                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)) {
                is_mobile = true ;
            } else {
                is_mobile = false ;
            }
            return is_mobile;
        }

        function isNotMobile() {
            return !isMobile();
        }

        if (isMobile() || true) {
            document.querySelector('#mobile_ad_phone_prev').classList.remove('uk-hidden');
        } else {
            // document.querySelector('#desktop_ad_phone_prev').classList.remove('uk-hidden');
        }

        // @todo map invalidate size won't work
        var observer = new MutationObserver(function(mutations) {
            mapInvalidateFunction();
        });
        observer.observe(document.querySelector('#map'), {
            attributes: true,
            childList: true,
            subtree: true
        });
    </script>
@endsection
