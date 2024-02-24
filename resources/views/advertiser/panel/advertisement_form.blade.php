@php
    $packages = \App\Models\Package::where('active', 1)->get();
@endphp
<div class="uk-container">
    <h2 class="uk-card-title">ثبت آگهی</h2>
    @if(!Auth::check())
        <div class="uk-alert-warning" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p>کاربر گرامی، با مشخصات وارد شده برای شما حساب کاربری ایجاد می‌گردد، و پس از ثبت آگهی به پنل خود منتقل می‌شوید.</p>
        </div>
    @endif
    <ul class="uk-flex-center" id="step-tabset" uk-tab>
        <li id="tab-1" class="tab-1 uk-active"><a onclick="showStep(1)">مشخصات فردی</a></li>
        <li id="tab-2" class="tab-2"><a onclick="showStep(2)">مشخصات کسب و کار</a></li>
        <li id="tab-3" class="tab-3"><a onclick="showStep(3)">شبکه‌های مجازی</a></li>
        <li id="tab-4" class="tab-4"><a onclick="showStep(4)">تصاویر کسب‌وکار</a></li>
        <li id="tab-5" class="tab-5"><a onclick="showStep(5)">آدرس</a></li>
    </ul>
    <div class="step uk-container" id="step-1">
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
            <div class="uk-flex-center" uk-grid>
                <div>
                    <label class="uk-text-small" for="fullname">نام و نام خانوادگی</label>
                    <input class="uk-input" type="text" name="fullname" id="fullname" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                </div>
                <div>
                    <label class="uk-text-small" for="phone">شماره همراه</label>
                    <input class="uk-input" type="text" name="phone" id="phone" value="{{ Auth::check() ? Auth::user()->phone_number : '' }}">
                </div>
                <div>
                    <label class="uk-text-small" for="email">ایمیل</label>
                    <input class="uk-input" type="text" name="email" id="email" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                </div>
            </div>
            <div class="uk-flex-center" uk-grid>
                <div>
                    <button onclick="showStep(2)" class="uk-button">مرحله بعد</button>
                </div>
            </div>
        </div>
    </div>
    <div class="step uk-container uk-hidden" id="step-2">
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
            <div class="uk-flex-center uk-child-width-1-2@m" uk-grid>
                <div>
                    <label class="uk-text-small" for="business_name">نام کسب و کار</label>
                    <input class="uk-input" type="text" name="business_name" id="business_name">
                </div>
                <div>
                    <label class="uk-text-small" for="business_category">گروه شغلی <span class="uk-text-meta">(جستجوی بین بیش از ۹۰۰ گروه شغل)</span></label>
                    <select class="uk-select" name="business_category" id="business_category" autocomplete="on"></select>
                </div>
                <div>
                    <div class="uk-flex uk-child-width-1-2@m">
                        <div>
                            <label class="uk-text-small" for="work_hours_start">ساعت شروع کار</label>
                            <input oninput="handle24H(this)" class="uk-input" type="number" min=1 max=24 name="work_hours[]" id="work_hours_start" placeholder="ساعت شروع" value="8">
                        </div>
                        <div>
                            <label class="uk-text-small" for="work_hours_end">ساعت پایان کار</label>
                            <input oninput="handle24H(this)" class="uk-input" type="number" min=1 max=24 name="work_hours[]" id="work_hours_end" placeholder="ساعت پایان" value="17">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="uk-text-small" for="off_days">روزهای تعطیل</label>
                    <select class="uk-select" name="off_days[]" id="off_days" multiple>
                        <option value="saturday">شنبه</option>
                        <option value="sunday">یکشنبه</option>
                        <option value="monday">دوشنبه</option>
                        <option value="tuesday">سه شنبه</option>
                        <option value="wednesday">چهارشنبه</option>
                        <option value="thursday">پنج شنبه</option>
                        <option value="friday">جمعه</option>
                    </select>
                </div>
                <div>
                    <label class="uk-text-small" for="address">آدرس کسب و کار</label>
                    <input class="uk-input" type="text" name="address" id="address">
                </div>
                <div>
                    <label class="uk-text-small" for="work_hours_start">شماره تماس کسب و کار</label>

                    <input class="uk-input" type="text" name="business_number" id="business_number">
                </div>
            </div>
            <div class="uk-flex-center" uk-grid>
                <div>
                    <button onclick="showStep(1)" class="uk-button">مرحله قبل</button>
                </div>
                <div>
                    <button onclick="showStep(3)" class="uk-button">مرحله بعد</button>
                </div>
            </div>
        </div>
    </div>
    <div class="step uk-container uk-hidden" id="step-3">
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
            <div class="uk-flex-center uk-child-width-1-2@m" id="social_wrapper" uk-grid>
                <div>
                    <input class="uk-input" type="text" name="website" id="website" placeholder="آدرس وبسایت">
                </div>
                <div>
                    <input class="uk-input" type="text" name="instagram" id="instagram" placeholder="اینستاگرام">
                </div>
                <div>
                    <input class="uk-input" type="text" name="telegram" id="telegram" placeholder="تلگرام">
                </div>
                <div>
                    <input class="uk-input" type="text" name="whatsapp" id="whatsapp" placeholder="واتساپ">
                </div>
                <div>
                    <input class="uk-input" type="text" name="eitaa" id="eitaa" placeholder="ایتا">
                </div>
                <div>
                    <input class="uk-input" type="text" name="other_social[]" placeholder="سایر">
                </div>
                <div>
                    <input class="uk-input" type="text" name="other_social[]" placeholder="سایر ۲">
                </div>
            </div>
            <div class="uk-text-left uk-margin-small-top uk-margin-small-bottom">
                <button onclick="addTempSocialLink()" class="uk-button uk-button-default"><span class="uk-icon" uk-icon="plus"></span> افزودن</button>
            </div>
            <div class="uk-flex-center" uk-grid>
                <div>
                    <button onclick="showStep(2)" class="uk-button">مرحله قبل</button>
                </div>
                <div>
                    <button onclick="showStep(4)" class="uk-button">مرحله بعد</button>
                </div>
            </div>
        </div>
    </div>
    <div class="step uk-container uk-hidden" id="step-4">
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
            <div class="uk-flex-center uk-child-width-1-1@m" uk-grid>
                <div>
                    <div class="uk-alert-danger" uk-alert>
                        <p><ion-icon name="alert-outline"></ion-icon> حداکثر ۵ تصویر می‌توانید انتخاب کنید.</p>
                    </div>
                    <div class="js-upload uk-placeholder uk-text-center">
                        <span uk-icon="icon: image"></span>
                        <span class="uk-text-middle">تصاویر را در این بخش رها کرده و یا </span>
                        <div uk-form-custom>
                            <input id="business_images" name="business_images" type="file" onchange="renderAdvertisementFormImagesPreview()" multiple>
                            <span class="uk-link">انتخاب کنید.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-child-width-1-5@m uk-child-width-1-2@s uk-text-center" uk-grid>
                <div><img src="" alt="" class="file_prev" id="file_prev_1"><span class="uk-text-meta" id="file_prev_name_1"></span></div>
                <div><img src="" alt="" class="file_prev" id="file_prev_2"><span class="uk-text-meta" id="file_prev_name_2"></span></div>
                <div><img src="" alt="" class="file_prev" id="file_prev_3"><span class="uk-text-meta" id="file_prev_name_3"></span></div>
                <div><img src="" alt="" class="file_prev" id="file_prev_4"><span class="uk-text-meta" id="file_prev_name_4"></span></div>
                <div><img src="" alt="" class="file_prev" id="file_prev_5"><span class="uk-text-meta" id="file_prev_name_5"></span></div>
            </div>
            <div class="uk-flex-center" uk-grid>
                <div>
                    <button onclick="showStep(3)" class="uk-button">مرحله قبل</button>
                </div>
                <div>
                    <button onclick="showStep(5)" class="uk-button">مرحله بعد</button>
                </div>
            </div>
        </div>
    </div>
    <div class="step uk-container uk-hidden" id="step-5">

        <div class=" uk-flex uk-flex-column uk-width-1-2@m">
{{--             <div uk-grid>--}}
            <div class=" ">
{{--                <div class="">--}}
{{--                    Test<br>--}}
{{--                    test--}}
{{--                </div>--}}

                <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-border-rounded">
                    <!-- uk-hidden added to remove search from page -->
                    <div class="uk-padding-small uk-hidden" >
                        <div class="uk-width-2-3@m">
                            <input class="uk-input uk-input-dark" type="text" id="query" placeholder="جستجوی مکان">
                        </div>
                        <div class="uk-width-expand">
                            <button class="uk-button uk-button-default" onClick="searchApi()">
                                جستجو
                            </button>
                        </div>
                    </div>
                    <div class="uk-margin-medium-top" id="results"></div>
                </div>
                <!--  -->
                <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-border-rounded">
                    <div class="uk-flex-center">
                        <div class="uk-margin-small-bottom">
                            <label for="province">استان</label>
                            @include('globalComponents.provincesSelect', ['name' => 'province', 'id' => 'province', 'hasAll' => false, 'onClick' => 'listProvinceCities(\'#province\', \'#city\', false, true)'])
                        </div>
                        <div class="uk-margin-small-bottom">
                            <label for="city">شهر</label>
                            <span class="uk-hidden" id="city_loader" uk-spinner="ratio: .5"></span>
                            <select class="uk-select uk-disabled" onchange="moveMapToQuery()" name="city" id="city"></select>
                            {{--                                @include('globalComponents.citiesSelect', ['name' => 'city', 'id' => 'city', 'hasAll' => false])--}}
                        </div>
                        <div class="uk-margin-small-bottom">
                            <label for="description">توضیحات</label>
                            <textarea class="uk-textarea" name="description" id="description" cols="30" rows="5" placeholder="توضیحات در مورد کسب و کار"></textarea>
                        </div>

                        <div class="uk-margin-small-bottom uk-hidden">
                            <br>test<br>
                            <label for="package">بسته تبلیغات</label>
                            <select onchange="showPackageInfo(this)" class="uk-select" aria-label="Select" id="package" name="package">
                                <option value="0">انتخاب کنید</option>
                                @foreach($packages as $package)
                                    <option data-price="{{ number_format($package->price, 0) }}" data-price-unit="{{ $package->price_unit }}" data-desc="@if($package->has_gift) {{ "بسته درخواستی شامل {$package->gift_duration_in_days} روز هدیه برای اولین بار می‌باشد." }} @endif" value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                            <span class="uk-text-success" id="package-price"></span>
                            <span class="uk-text-meta" id="package-price-unit"></span>
                            <br>
                            <span class="uk-text-success" id="package-info"></span>
                        </div>
                        <div class="uk-flex-center" uk-grid>
                            <div>
                                <button onclick="showStep(4)" class="uk-button">مرحله قبل</button>
                            </div>

                            <div>
                                <button onclick="submitAdvertisementForm()" class="uk-button uk-button-primary">ثبت کسب و کار</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-flex-first">

                    <div class="uk-border-rounded uk-width-expand" id="map"></div>

                    <form action="{{ route('Advertiser > Create') }}" method="post" class="uk-hidden">
                        @csrf
                        <input class="uk-input uk-disabled" type="text" name="lat" id="lat">
                        <input class="uk-input uk-disabled" type="text" name="lng" id="lng">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


