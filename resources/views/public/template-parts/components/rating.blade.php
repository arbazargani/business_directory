@php
    $rating = isset($ad->getRatings()->rating) ? number_format((float)$ad->getRatings()->rating, 1, '.', '') : null;
@endphp
<div class="uk-container uk-background-primary uk-text-center uk-padding uk-border-rounded uk-light uk-margin-medium-top" id="rating-container">
    <input type="hidden" id="ad_id" value="{{ $ad->id }}">
    <p class="title">به این کسب و کار امتیاز بدهید</p>
    <p class="rate @if(!isset($ad->getRatings()->rating)) uk-hidden @endif" id="ad_rating_preview">@if(isset($ad->getRatings()->rating)) {{ \App\Helpers\Helper::faNum($rating) }} @endif</p>
    <span>
    	<ion-icon onclick='rateAdvertisement(this)' data-value='1' class="rating-star"  name="star-outline"></ion-icon>
    </span>
    <span>
    	<ion-icon onclick='rateAdvertisement(this)' data-value='2' class="rating-star"  name="star-outline"></ion-icon>
    </span>
    <span>
    	<ion-icon onclick='rateAdvertisement(this)' data-value='3' class="rating-star"  name="star-outline"></ion-icon>
    </span>
    <span>
    	<ion-icon onclick='rateAdvertisement(this)' data-value='4' class="rating-star"  name="star-outline"></ion-icon>
    </span>
    <span>
    	<ion-icon onclick='rateAdvertisement(this)' data-value='5' class="rating-star"  name="star-outline"></ion-icon>
    </span>
</div>
