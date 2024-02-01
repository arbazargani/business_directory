<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
@if(\Illuminate\Support\Facades\Request::is('business/*'))
<meta name="description" content="{{ (strlen($ad->desc) > 0) ? substr($ad->desc, 0, 156) . ' ...' : $ad->business_name }}">
<meta name="robots" content="index, follow">
<meta name="keywords" content="{{ "{$ad->getCategory()}, {$ad->getCategory()} در {$ad->city}, {$ad->getCategory()} در {$ad->province}, $ad->business_name"  }}">
<link rel="canonical" href="{{ urldecode(\Illuminate\Support\Facades\Request::fullUrl()) }}">

<meta property="og:locale" content="{{ app()->currentLocale() }}">
<meta property="og:title" content="{{ $ad->business_name }}">
<meta property="og:site_name" content="{{ env('APP_NAME') }}">
<meta property="og:description" content="{{ (strlen($ad->desc) > 0) ? substr($ad->desc, 0, 156) . ' ...' : $ad->business_name }}">
<meta property="og:type" content="place">
<meta property="og:url" content="{{ urldecode(\Illuminate\Support\Facades\Request::fullUrl()) }}">
@if(json_decode($ad->business_images) !== null)
    @foreach(json_decode($ad->business_images) as $img)
        <meta property="og:image" content="{{ asset("storage/$img") }}">
        <meta property="og:image:width" content="{{ getimagesize("storage/$img")[0] }}" />
        <meta property="og:image:height" content="{{ getimagesize("storage/$img")[1] }}" />
        <meta property="og:image:type" content="{{ getimagesize("storage/$img")['mime'] }}" />
    @endforeach
@endif

<meta name="twitter:site" content="{{ urldecode(\Illuminate\Support\Facades\Request::fullUrl()) }}" />
<meta name="twitter:title" content="{{ $ad->business_name }}" />
<meta name="twitter:description" content="{{ (strlen($ad->desc) > 0) ? substr($ad->desc, 0, 156) . ' ...' : $ad->business_name }}" />

<?php
    $weekdays = '';
    $offDays = json_decode($ad->off_days);
    $allDays = array_keys($translations['week_days']);
    $workingDays = array_diff($allDays, $offDays);
?>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Place",
        "name": "{{ $ad->business_name }}",
        "description": "{{ (strlen($ad->desc) > 0) ? substr($ad->desc, 0, 156) . ' ...' : $ad->business_name }}",
        "url": "{{ urldecode(\Illuminate\Support\Facades\Request::fullUrl()) }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $ad->address }}",
            "addressLocality": "{{ $ad->city }}",
            "addressRegion": "{{ $ad->province }}",
            "postalCode": "123456",
            "addressCountry": "IR"
        },
        "geo": {
            "@type": "GeoCoordinates",
                "latitude": {{ $ad->latitude }},
                "longitude": {{ $ad->longitude }}
        },
        "telephone": "{{ $ad->phone }}",
        "openingHours": [
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": [
                @foreach ($workingDays as $wd)
                "{{ $wd }}"@if(!$loop->last),@endif
                @endforeach
              ],
              "opens": "{{ json_decode($ad->work_hours, true)[0] }}:00:00",
              "closes": "{{ json_decode($ad->work_hours, true)[1] }}:00:00"
            },
            @foreach($offDays as $od)
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": "{{ $od }}",
              "closed": true
            }@if(!$loop->last),@endif
            @endforeach
        ],
        "acceptsReservations": false
    }
</script>
@endif
