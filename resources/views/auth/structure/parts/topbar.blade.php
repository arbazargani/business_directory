{{-- Topbar elems holder --}}
<div class="uk-padding">
    <div class="uk-child-width-1-2" uk-grid>
        <div>
            <h2 class="uk-text-lead">
                <span class="uk-icon uk-margin-small-left" uk-icon="grid"></span>
                {{ $title }}
            </h2>
        </div>
        <div class="uk-text-left">
            <div class="uk-inline">
                <span class="uk-icon uk-icon-button" uk-icon="user"></span>
                <div class="uk-text-right uk-border-rounded" uk-dropdown>
                    <ul class="uk-list uk-text-right">
                        <li>
                                                <span class="uk-text-meta"
                                                      style="font-weight: bold">{{ Auth::user()->name }}</span>
                        </li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <a class="uk-link-reset" href="/app/panel/profile">
                                                    <span class="uk-text-meta"><span class="uk-icon uk-margin-small-left"
                                                                                     uk-icon="pencil"></span> ویرایش اطلاعات</span>
                            </a>
                        </li>
                        <li>
                            <a class="uk-link-reset" onclick="logOutSession()">
                                                    <span class="uk-text-meta"><span class="uk-icon uk-margin-small-left"
                                                                                     uk-icon="sign-out"></span> خروج</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'Panel > Dashboard')
        <div class="uk-child-width-1-3@m uk-grid-match" uk-grid>
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    <h4 class="uk-card-title uk-text-default"><span class="uk-icon" uk-icon="users"></span>
                        پروفایل‌های شما</h4>
                    @forelse(Auth::user()->profiles as $profile)
                        <p class="uk-text-bold">
                            {{ $profile->name }}
                            <span
                                class="uk-text-light uk-text-default">{{ jdate($profile->created_at)->format('%A, %d %B %y') }}</span>
                        </p>
                    @empty
                        <div class="uk-alert uk-alert-warning">
                            <p class="uk-text-warning">پروفایلی ثبت نشده است.</p>
                        </div>
                        <button class="uk-button uk-button-small theme-primary-button uk-float-left">ثبت
                            پروفایل
                        </button>
                    @endforelse
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    <h4 class="uk-card-title uk-text-default"><span class="uk-icon"
                                                                    uk-icon="cart"></span>
                        سبدخرید</h4>
                    @if(!is_null(Auth::user()->cart->first()))
                        @forelse(Auth::user()->cart->first()->get() as $cart)
                            @php
                                $current_loop_diet = \App\Models\Diet::find($cart->getInformations()->items[0]->diet_id);
                            @endphp
                            <p class="uk-text-bold">{{ $current_loop_diet->name }}
                                {{ json_decode($current_loop_diet->diet_informations)->duration }} روزه
                                <span
                                    class="uk-text-light uk-text-default">{{ \App\Models\UserProfile::find($cart->getInformations()->items[0]->diet_profile_id)->name }}</span>
                            </p>
                        @empty
                            <div class="uk-alert uk-alert-warning">
                                <p class="uk-text-warning">رژیمی ثبت نکرده‌اید!</p>
                            </div>
                            <button class="uk-button uk-button-small theme-secondary-button uk-float-left">ثبت
                                رژیم
                            </button>
                        @endforelse
                    @else
                        <div class="uk-alert uk-alert-warning">
                            <p class="uk-text-warning">سبد خرید شما خالی می‌باشد.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    <h4 class="uk-card-title uk-text-default"><span class="uk-icon" uk-icon="nut"></span>
                        دسترسی سریع</h4>
                    <button
                        class="uk-button uk-button-small theme-secondary-button uk-width-expand uk-margin-small-bottom">
                        واتساپ پشتیبان رژیم
                    </button>
                    <button
                        class="uk-button uk-button-small theme-primary-button uk-width-expand uk-margin-small-bottom">
                        ثبت رژیم جدید
                    </button>
                    <button
                        class="uk-button uk-button-small theme-default-button uk-width-expand uk-margin-small-bottom">
                        اینستاگرام ازشنبه
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
