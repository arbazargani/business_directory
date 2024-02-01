@extends('public.sitemap')

@section('content')

@foreach($categories as $category)
<url>

    <loc>{{ urldecode(route('Category > Archive', $category->slug)) }}</loc>

{{--    <lastmod>{{ $category->updated_at }}</lastmod>--}}
    <lastmod>{{ gmdate('Y-m-d\TH:i:s+00:00', strtotime($category->updated_at)) }}</lastmod>

    <changefreq>hourly</changefreq>

    <priority>0.7</priority>

</url>
@endforeach

@endsection
