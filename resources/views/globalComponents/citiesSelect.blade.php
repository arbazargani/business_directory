@php
    $cities = \Illuminate\Support\Facades\Cache::remember('cities_list', 60*60*24*3, function () {
        $citeis = \App\Models\IranCity::all();
        return $citeis;
    });
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
