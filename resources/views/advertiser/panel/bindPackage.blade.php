@extends('advertiser.template')


@section('tmp_head')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .uk-grid {
            margin-right: -15px !important;
        }
        .uk-card-default {
            /*background: #262626;*/
        }
        #map {
            height: 500px;
            width: 100%;
        }
        .uk-input-dark {
            /* background-color: #383838;
            border: none;
            border-radius: 100px;
            color: #c4c4c4; */
        }

        .uk-input-dark:focus {
            /* background-color: #383838;
            border: none;
            border-radius: 100px;
            color: #c4c4c4; */
        }

        .uk-button-dark {
            /* background-color: #520085;
            border: none;
            border-radius: 100px;
            color: #c4c4c4;
            font-weight: 900; */
        }
        #results {
            max-height: 300px;
            overflow-x: auto;
        }

        #step-tabset {
            display: inline-block;
            overflow: auto;
            overflow-y: hidden;
            max-width: 100%;
            white-space: nowrap;
            padding: 7px;
            scroll-behavior: smooth;
        }

        #step-tabset li {
            display: inline-block;
            vertical-align: top;
        }

        th, td {
            text-align: right !important;
        }

        .package {
            cursor: pointer;
            transition: all .2s;
        }
        .package:hover {
            /*box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;*/
            box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
            /*border-radius: 10px;*/
            border: 1px solid #bffbff;
        }

        .checked {
            background: #55dae7;
            display: block;
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 20px;
            box-shadow: rgb(255 255 255 / 27%) 0px 3px 8px;

            opacity: 0;
            transition: all .2s;
        }
        .package:hover > div > .checked {
            opacity: 1;
        }


        /* .package-wrapper div:nth-child(1) div {
            background: #bffbff;
        }
        .package-wrapper div:nth-child(1) div h2 {
            color: #00737b;
        }
        .package-wrapper div:nth-child(1) div .package-price {
            color: #00737b;
        }

        .package-wrapper div:nth-child(2) div {
            background: #80f7ff;
        }
        .package-wrapper div:nth-child(2) div h2 {
            color: #00737b;
        }
        .package-wrapper div:nth-child(2) div .package-price {
            color: #00737b;
        }

        .package-wrapper div:nth-child(3) div {
            background: #00a0b0;
        }
        .package-wrapper div:nth-child(3) div h2 {
            color: #ffffff;
        }
        .package-wrapper div:nth-child(3) div .package-price {
            color: #ffffff;
        } */
    </style>
@endsection

@section('content')
    <div class="uk-container">
        <div class="uk-card uk-card-default uk-card-body">
            <h2 class="uk-card-title uk-text-medium">ارتقا آگهی <span class="uk-text-warning">{{ $advertisement->title }}</span></h2>
            <ul id="packages-accordion" uk-accordion>
                <li class="uk-open">
                    <a class="uk-accordion-title" href>پکیج‌ها</a>
                    <div class="uk-accordion-content">
                        <div class="uk-grid-collapse uk-grid-match uk-child-width-1-4@m uk-text-center uk-margin-medium-top package-wrapper" uk-grid>
                            @php
                                $c = 0;
                            @endphp
                            @foreach($packages as $package)
                                @php
                                    $c ++;
                                @endphp
                                <div class="package" onclick="choosePackage(this)" data-title="{{ Helper::faNum($package->name) }}" data-id="{{ $package->id }}">
                                    <div class="uk-background-muted uk-padding package-iteration-{{$loop->iteration}} package-iteration-{{$c}} package-name">
                                        <span class="checked"></span>
                                        <h2 class="uk-text-bolder">{{ Helper::faNum($package->name) }}</h2>
                                        <ul class="uk-list uk-list-not-striped">
                                            <li class="uk-text-large uk-text-bold package-price">{{ Helper::faNum(number_format($package->price, 0)) }} تومان</li>
                                            @if($package->has_gift)
                                                <li><span class="uk-text-success uk-text-bold package-gift">{{ Helper::faNum($package->gift_duration_in_days) }} روز هدیه</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                @php
                                    if ($c == 3) {
                                        $c = 0;
                                    }
                                @endphp
                                @if($c == 3)
                                    <br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
            <div class="uk-flex uk-flex-center">
                <div class="uk-card uk-card-body uk-card-default uk-border-rounded uk-text-center uk-width-1-2@m uk-hidden"
                     style="border: 1px solid #e7e7e7"
                     id="package-prev-wrapper">
                    <div class="uk-width-1-1">
                        <h2 class="uk-text-default">پکیج انتخابی شما</h2>
                        <p class="uk-text-default uk-text-bold" id="package-name-prev"></p>
                        <input type="hidden" name="package-id" id="package-id">
                    </div>
                    <div class="uk-width-1-1">
                        <button class="uk-button uk-button-muted uk-button-text uk-margin-small-left" onclick="togglePackagesAccordion()">تغییر پکیج</button>
                        <button class="uk-button uk-border-rounded" style="background: #00A0B0; color: white" onclick="goToCard(this)">تایید و پرداخت</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('tmp_scripts')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                UIkit.notification('{{ $error }}');
            @endforeach
        @endif

        @if(isset($message))
            UIkit.notification('{{ $message }}');
        @endif
    </script>
    <script>
        function togglePackagesAccordion() {
            let title = document.querySelector('.uk-accordion-title');
            if (title.innerText === 'پکیج‌ها') {
                title.innerText = 'نمایش پکیج‌ها';
            } else {
                title.innerText = 'پکیج‌ها';
            }
            UIkit.accordion(document.querySelector('#packages-accordion')).toggle(1, true);
        }
        function choosePackage(dispatcher) {
            togglePackagesAccordion();
            document.querySelector('#package-prev-wrapper').classList.remove('uk-hidden');
            document.querySelector('#package-name-prev').innerText = dispatcher.dataset.title;
            document.querySelector('#package-id').value = dispatcher.dataset.id;
        }

        function goToCard(dispatcher) {
            let package_id = document.querySelector('#package-id').value;
            axios.post(window.location.href, {
                package_id: package_id
            })
            .then(function (response) {
                // handle success
                if (response.data.status == 200) {
                    UIkit.notification({
                        message: response.data.messages.fa,
                        status: 'success',
                        pos: 'top-center',
                        timeout: 5000
                    });
                    if (response.data.hasOwnProperty('allowed') && response.data.hasOwnProperty('timestamp') && response.data.allowed) {
                        window.location.replace(response.data.redirect);
                    } else {
                        UIkit.notification({
                            message: error_icon + 'مشکلی پیش آمده است.',
                            status: 'warning',
                            pos: 'bottom-right',
                            timeout: 5000
                        });
                    }
                } else {
                    UIkit.notification({
                        message: error_icon + response.data.errors[AppLocale],
                        status: 'danger',
                        pos: 'bottom-right',
                        timeout: 5000
                    });
                }
            })
            .catch(function (error) {
                // handle error
                // console.log(error);
            })
            .finally(function () {
                    // always executed
                });
        }
    </script>
@endsection
