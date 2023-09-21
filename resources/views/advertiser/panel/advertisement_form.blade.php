<div class="uk-container">
    <h2 class="uk-card-title">ثبت آگهی</h2>
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
                    <input class="uk-input" type="text" name="fullname" id="fullname" placeholder="نام و نام خانوادگی" value="{{ Auth::user()->name }}">
                </div>
                <div>
                    <input class="uk-input" type="text" name="phone" id="phone" placeholder="شماره تماس" value="{{ Auth::user()->phone_number }}">
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
                    <input class="uk-input" type="text" name="business_name" id="business_name" placeholder="نام کسب و کار">
                </div>
                <div>
                    <input class="uk-input" type="text" name="business_category" id="business_category" placeholder="دسته شغلی">
                </div>
                <div>
                    <input class="uk-input" type="text" name="work_hours" id="work_hours" placeholder="ساعت کاری">
                </div>
                <div>
                    <input class="uk-input" type="text" name="off_days" id="off_days" placeholder="روزهای تعطیل">
                </div>
                <div>
                    <input class="uk-input" type="text" name="address" id="address" placeholder="آدرس کسب و کار">
                </div>
                <div>
                    <input class="uk-input" type="text" name="business_number" id="business_number" placeholder="شماره کسب و کار">
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
            <div class="uk-flex-center uk-child-width-1-2@m" uk-grid>
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
                    <input class="uk-input" type="text" name="other_social_1" id="other_social_1" placeholder="سایر">
                </div>
                <div>
                    <input class="uk-input" type="text" name="other_social_2" id="other_social_2" placeholder="سایر ۲">
                </div>
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
                    <div class="js-upload uk-placeholder uk-text-center">
                        <span uk-icon="icon: image"></span>
                        <span class="uk-text-middle">تصاویر را در این بخش رها کرده و یا </span>
                        <div uk-form-custom>
                            <input id="business_images" name="business_images" type="file" multiple>
                            <span class="uk-link">انتخاب کنید.</span>
                        </div>
                    </div>
                </div>

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
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
            <div uk-grid>
                <div class="uk-width-1-2@m">
                    <div class="uk-card uk-card-body uk-card-default uk-padding-small uk-border-rounded">
                    <!-- uk-hidden added to remove search from page -->
                        <div class="uk-padding-small uk-hidden" uk-grid>
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
                                <input type="text" class="uk-input" name="province" id="province" placeholder="استان">
                            </div>
                            <div class="uk-margin-small-bottom">
                                <input type="text" class="uk-input" name="city" id="city" placeholder="شهرستان">
                            </div>
                            <div class="uk-margin-small-bottom">
                                <textarea class="uk-textarea" name="full_address" id="full_address" cols="30" rows="10" placeholder="آدرس کامل"></textarea>
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
                </div>
                <div class="uk-width-expand">
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
