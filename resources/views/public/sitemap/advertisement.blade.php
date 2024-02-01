@extends('public.sitemap')

@section('content')

@foreach($advertisements as $ad)
<url>

    <loc>{{ urldecode($ad->getSlug()) }}</loc>

    <lastmod>{{ gmdate('Y-m-d\TH:i:s+00:00', strtotime($ad->updated_at)) }}</lastmod>

    <changefreq>hourly</changefreq>

    <priority>0.9</priority>
    @if(json_decode($ad->business_images) !== null)
    <image:image>
        <image:loc>{{ asset("storage/" . json_decode($ad->business_images)[0]) }}</image:loc>
        <image:caption>{{ $ad->title }}</image:caption>
        <image:title>{{ $ad->title }}</image:title>
    </image:image>
    @endif
</url>
@endforeach

@endsection
