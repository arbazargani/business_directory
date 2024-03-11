@extends('public.template')

@section('page_title')
    صفحه اصلی
@endsection

@section('content')
    @include('public.template-parts.components.search_form')
    <div class="uk-container">
        <h2 class="uk-text-lead">کسب و کارهای اخیر</h2>
        <div class="uk-grid-small uk-child-width-1-3@m uk-grid-match" uk-grid>
            @foreach($advertisements['commercial'] as $ad)
                @include('public.template-parts.components.adcardCommercial')
            @endforeach
        </div>
{{--        <hr>--}}
{{--        <h2 class="uk-text-lead">کسب و کار های اخیر</h2>--}}
{{--        @foreach($advertisements['basic'] as $ad)--}}
{{--            @include('public.template-parts.components.adcard')--}}
{{--        @endforeach--}}
    </div>
@endsection

@section('tmp_scripts')
@endsection
