@extends('public.sitemap')

@section('content')

@foreach($tags as $tag)
<url>

    <loc>{{ urldecode(route('Tag > Archive', $tag->slug)) }}</loc>

{{--    <lastmod>{{ $tag->updated_at }}</lastmod>--}}
    <lastmod>{{ gmdate('Y-m-d\TH:i:s+00:00', strtotime($tag->updated_at)) }}</lastmod>

    <changefreq>hourly</changefreq>

    <priority>0.7</priority>

</url>
@endforeach

@endsection
