@extends('public.template')


@section('page_title')
{{ $page[0]->title }}
@endsection

@section('tmp_header')
@if(!is_null($page[0]->meta_description))
<meta name="description" content="{{ $page[0]->meta_description }}">
@endif
@if(!is_null($page[0]->meta_robots))
<meta name="robots" content="{{ $page[0]->meta_robots }}">
@endif
@endsection

@section('content')
<div class="uk-container uk-container-small">
    <ul class="uk-breadcrumb uk-margin-medium-right">
        <li><a href="{{ route('Public > Home') }}">خانه</a></li>
        <li><a href="#">صفحات</a></li>
        <li class="uk-disabled"><a>{{ $page[0]->title }}</a></li>
    </ul>
    <div class="uk-card uk-card-default uk-card-body">
        <div class="uk-article">
            <article class="article uk-background-default uk-border-rounded">
                <!-- article meta box -->
                <div>
                    @if($page[0]->cover)
                        <img class="uk-align-center uk-border-rounded" src="/storage/uploads/articles/images/{{ $page[0]->cover }}" alt="{{ $page['0']->meta_title }}" uk-img>
                    @endif
                    <metabox>
                        <div class="uk-container uk-background-muted uk-padding@m uk-border-rounded">
                            <h1 class="uk-margin-top uk-text-lead uk-text-center">{{ $page[0]->title }}</h1>
                            <hr />
                        </div>
                    </metabox>

                </div>
                <!-- article meta box -->


                <content class="uk-text-justify">
                    <div class="uk-margin-medium-top">
                        {!! $page[0]->content !!}
                    </div>
                </content>

                <metabox>
                    <div class="uk-container uk-text-center uk-background-muted uk-padding uk-border-rounded">

                        <a class="uk-icon-button" uk-icon="whatsapp" rel="nofollow" href="whatsapp://send?text={{ urldecode(urlencode(route('Public > Page > Single', $page[0]->slug))) }}" target="_blank"></a>

                        <a class="uk-icon-button" uk-icon="twitter" rel="nofollow" href="http://twitter.com/intent/tweet/?text={{ $page[0]->meta_description }};url={{ urldecode(urlencode(route('Public > Page > Single', $page[0]->slug))) }}" target="_blank"></a>

                        <a class="uk-icon-button" uk-icon="linkedin" rel="nofollow" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urldecode(urlencode(route('Public > Page > Single', $page[0]->slug))) }};title={{ $page[0]->title }};source={{ route('Public > Home') }}" target="_blank"></a>

                    </div>
                    <metabox>
            </article>
        </div>
    </div>
</div>
@endsection
