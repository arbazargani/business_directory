@php
    $cities = [];
    if (\Illuminate\Support\Facades\Request::has('search_location') && \Illuminate\Support\Facades\Request::get('search_location') !== '-1') {
        $cities = \App\Models\IranCity::where('province_id', \Illuminate\Support\Facades\Request::get('search_location'))->get();
    }
    $name = isset($name) ? $name : null;
    $id = isset($id) ? $id : null;
    $class = isset($class) ? $class : null;
    $selected = isset($selected) ? $selected : false;
    $hasAll = isset($hasAll) ? $hasAll : true;
@endphp

<select class="uk-select {{ $class }}" name="{{ $name }}" id="{{ $id }}">
    @if($hasAll)
        <option value="-1">همه شهرها</option>
    @endif
    @foreach($cities as $city)
        <option value="{{ $city->id }}" @if($selected !== false && $selected === $city->id) selected @endif>{{ $city->name }}</option>
    @endforeach
</select>
