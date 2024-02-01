@extends('public.sitemap')

@section('content')

<url>

    <loc>{{ route('Public > Home') }}</loc>

    <lastmod>{{ gmdate('Y-m-d\TH:i:s+00:00', strtotime(date('Y-m-d H:i:s'))) }}</lastmod>

    <changefreq>monthly</changefreq>

    <priority>0.8</priority>

</url>

<url>

    <loc>{{ route('Sitemap > Advertisements') }}</loc>

    <lastmod>{{ gmdate('Y-m-d\TH:i:s+00:00', strtotime(App\Models\Advertisement::where('confirmed', 1)->latest()->take(1)->first()->updated_at)) }}</lastmod>

    <changefreq>monthly</changefreq>

    <priority>0.8</priority>

</url>

<url>

    <loc>{{ route('Sitemap > Pages') }}</loc>

    <lastmod>{{ gmdate('Y-m-d\TH:i:s+00:00', strtotime(App\Models\Page::latest()->first()->updated_at )) }}</lastmod>

    <changefreq>monthly</changefreq>

    <priority>0.8</priority>

</url>

@endsection
