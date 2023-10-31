@php
    $provinces = \Illuminate\Support\Facades\Cache::remember('provinces_list', 60*60*24*3, function () {
        $provinces = \App\Models\IranProvince::all();
        return $provinces;
    });
    $name = isset($name) ? $name : null;
    $id = isset($id) ? $id : null;
    $class = isset($class) ? $class : null;
    $selected = isset($selected) ? $selected : false;
    $hasAll = isset($hasAll) ? $hasAll : true;
@endphp

<select class="uk-select {{ $class }}" name="{{ $name }}" id="{{ $id }}">
    @if($hasAll)
        <option value="-1">همه استان‌ها</option>
    @endif
    @foreach($provinces as $province)
        <option value="{{ $province->id }}" @if($selected !== false && $selected === $province->id) selected @endif>{{ $province->name }}</option>
    @endforeach
</select>
