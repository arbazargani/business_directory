@extends('public.template')

@section('content')
    @include('public.template-parts.components.search_form')
    <div class="uk-container">
        @php
            $q = (\Illuminate\Support\Facades\Request::has('search_query'))
            ? \Illuminate\Support\Facades\Request::get('search_query')
            : null;
            $c = (\Illuminate\Support\Facades\Request::has('search_location')) && (\Illuminate\Support\Facades\Request::get('search_location') !== '-1')
            ? \Illuminate\Support\Facades\Cache::get('cities_list')->find(\Illuminate\Support\Facades\Request::get('search_location'))->name
            : 'همه شهرها';
        @endphp
        <h2 class="uk-text-lead">نتایج جستجو @if(strlen($q) > 0): <strong class="uk-text-bolder">{{ $q }}</strong> در <strong class="uk-text-bolder">{{ $c }}</strong> @endif</h2>
        <div class="uk-grid-small uk-child-width-1-3@m uk-grid-match" uk-grid>
            @forelse($ads as $ad)
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
