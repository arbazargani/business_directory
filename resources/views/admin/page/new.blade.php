@extends('admin.template')

@section('head')
<title>ایجاد مقاله جدید</title>
@endsection

@section('content')
    <h2 id="lightbox" class="uk-h2 tm-heading-fragment">
        ایجاد صفحه جدید
    </h2>
    @if($errors->any())
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form class="uk-grid-small uk-position-relative uk-grid" uk-grid action="{{ route('Admin > Page > Submit') }}" method="POST">
        @csrf
        <div class="uk-width-2-3@m">
            <div class="uk-inline uk-width-1-1 uk-first-column uk-margin-small-bottom">
                <input type="text" name="title" id="title" placeholder="عنوان" class="uk-input form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required style="padding-left: 40px;" autofocus>
            </div>
            <div class="uk-inline uk-width-1-1 uk-first-column">
                <textarea name="content" id="tinymceEditor" placeholder="محتوای اصلی مقاله خود را وارد کنید." class="uk-input uk-textarea form-control @error('content') is-invalid @enderror" style="padding-left: 40px;">{{ old('content') }}</textarea>
                <hr>
                <div class="uk-card uk-card-secondary uk-card-body uk-border-rounded">
                    <h3 class="uk-card-title">تنظیمات</h3>
                    <div class="uk-inline uk-width-1-1 uk-first-column uk-margin-small-bottom">
                        <!-- meta description -->
                        <div class="">
                            <label class="uk-form-label" for="meta-description">اسنیپت (Meta:description)</label>
                            <textarea type="text" name="meta-description" id="meta-description" placeholder="توضیحات متا" class="uk-textarea form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required style="padding-left: 40px;" onkeydown="checkLength();"></textarea>
                            <style>
                                #meta-description-state {
                                    width: 0%;
                                    height: 4px!important;
                                }
                            </style>
                            <div id="meta-description-state" style="width: 100%; height: 10px!important"></div>
                            <p>
                            <ul>
                                <li>حداقل ۱۲۰ کاراکتر باشد.</li>
                                <li>حداکثر ۱۶۰ کاراکتر باشد.</li>
                                <li>بهتر است شامل کلمات کلیدی باشد.</li>
                            </ul>
                            </p>
                            <script>
                                function checkLength() {
                                    var len = document.getElementById('meta-description').value.length;
                                    if (len >= 1 && len <= 70) {
                                        document.getElementById('meta-description-state').setAttribute('style', 'background: red; width: 30%;');
                                    }
                                    else if ( len >= 70 && len <= 120 ) {
                                        document.getElementById('meta-description-state').setAttribute('style', 'background: orange; width: 40%;');
                                    }
                                    else if ( len >= 120  && len <= 160 ) {
                                        document.getElementById('meta-description-state').setAttribute('style', 'background: green; width: 100%;');
                                    } else (
                                        document.getElementById('meta-description-state').setAttribute('style', 'background: red; width: 100%;')
                                    )
                                }
                            </script>
                        </div>
                        <!-- meta robots -->
                        <div>
                            <label class="uk-form-label" for="meta-robots">خزنده (Meta:robots)</label>
                            <select class="uk-select" name="meta-robots">
                                <option value="index, follow">index, follow</option>
                                <option value="noindex">noindex</option>
                                <option value="nofollow">nofollow</option>
                                <option value="noindex, nofollow">noindex, nofollow</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-3@m">
            <button type="submit" name="publish" class="uk-button uk-button-primary uk-border-rounded" value="1">انتشار</button>
            <button type="submit" name="draft" class="uk-button uk-button-default uk-border-rounded" value="1">پیش‌نویس</button>
        </div>
    </form>
@endsection
