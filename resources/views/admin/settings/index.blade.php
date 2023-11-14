@extends('admin.template')

@section('head')
    <title>{{ env('APP_NAME') . ' - تنظیمات' }}</title>
@endsection

@section('content')
    <h2>تنظیمات سامانه</h2>
    <div class="uk-card uk-card-default uk-card-body">
        <form class="uk-form-stacked" method="POST">
            @csrf
            @foreach($settings as $setting)
                <div class="uk-margin">
                    <label class="uk-form-label" for="{{ $setting->name }}">{{ $setting->name }}</label>
                    <div class="uk-form-controls">
                        <input class="uk-input {{ $setting->class_list  }}" id="{{ $setting->name }}" name="{{ $setting->name }}" type="{{ $setting->input_type }}" {{ $setting->attributes_string }} value="{{ $setting->value }}">
                    </div>
                </div>
            @endforeach

            <div class="uk-margin">
                <button class="uk-button uk-button-primary">ذخیره تنظیمات</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
