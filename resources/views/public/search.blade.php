@extends('public.template')

@section('page_title')
    نتایچ جستجو
@endsection

@section('tmp_header')
    <style>
        .query_filters span.action {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    @include('public.template-parts.components.search_form')
    <div class="uk-container">
        @php
            $q = (\Illuminate\Support\Facades\Request::has('search_query'))
            ? \Illuminate\Support\Facades\Request::get('search_query')
            : null;
            $cNum = (\Illuminate\Support\Facades\Request::has('search_location')) && (\Illuminate\Support\Facades\Request::get('search_location') !== '-1')
            ? \Illuminate\Support\Facades\Cache::get('provinces_list')->find(\Illuminate\Support\Facades\Request::get('search_location'))->id
            : '-1';
            $c = (\Illuminate\Support\Facades\Request::has('search_location')) && (\Illuminate\Support\Facades\Request::get('search_location') !== '-1')
            ? \Illuminate\Support\Facades\Cache::get('provinces_list')->find(\Illuminate\Support\Facades\Request::get('search_location'))->name
            : 'همه استان‌ها';
            $sort = (\Illuminate\Support\Facades\Request::has('sort')) && (\Illuminate\Support\Facades\Request::get('sort') !== '-1')
            ? \Illuminate\Support\Facades\Request::get('sort')
            : '-1'
        @endphp
        <div class="query_filters">
            <span class="uk-text-meta">مرتب سازی بر اساس <ion-icon name="arrow-forward-outline" style="vertical-align: middle"></ion-icon>
                <span class="@if($sort == 'published_at') uk-text-bold @endif action"><a href="{{ \Illuminate\Support\Facades\Request::getRequestUri() }}&sort=published_at" class="uk-link-reset">تاریخ</a></span>
                ، <span class="@if($sort == 'hits') uk-text-bold @endif action"><a href="{{ \Illuminate\Support\Facades\Request::getRequestUri() }}&sort=hits" class="uk-link-reset">پرطرفدار</a></span>
            </span>
            <span class="uk-margin-small-right uk-text-meta uk-text-danger action">
                <a href="{{ route('Public > Search') }}?search_query={{ $q }}&search_location={{ $cNum }}" class="uk-link-reset">مرتب‌سازی پیش‌فرض</a>
            </span>
        </div>
        <h2 class="uk-text-lead">نتایج جستجو @if(strlen($q) > 0): <strong class="uk-text-bolder">{{ $q }}</strong> در <strong class="uk-text-bolder">{{ $c }}</strong> @endif</h2>
        <div class="uk-grid-small uk-child-width-1-3@m uk-grid-match" uk-grid>
        @forelse($ads['commercial'] as $ad)
            @include('public.template-parts.components.adcardCommercial')
        @empty

        @endforelse
        </div>
        <hr>
        <div class="uk-grid-small uk-child-width-1-3@m uk-grid-match" uk-grid>
            @forelse($ads['basic'] as $ad)
                @include('public.template-parts.components.adcard')
            @empty
                <div class="uk-alert-warning" uk-alert>
                    <p>متاسفانه جستجوی شما نتیجه‌ای در بر نداشت.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('tmp_scripts')
@endsection
