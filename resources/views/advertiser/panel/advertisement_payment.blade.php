@extends('advertiser.template')


@section('tmp_head')
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
    </style>
@endsection

@section('content')
    <div class="uk-container">
        <div class="uk-card uk-card-default uk-card-body">
            <h2 class="uk-card-title">صورتحساب مشتری @if($transaction->paid) <span class="uk-label uk-label-success">پرداخت شده</span> @else <span class="uk-label uk-label-danger">پرداخت نشده</span> @endif</h2>
            <p class="uk-text-default">خرید پکیج {{ $package->name }}</p>
            <table class="uk-table uk-table-divider uk-table-striped uk-table-middle">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>مدت زمان</th>
                    <th>تخفیف</th>
                    <th>مبلغ (تومان)</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>۱</td>
                    <td>
                        <p>
                            پکیج {{ $package->name }}
                        </p>
                        <span class="uk-text-meta uk-text-warning">برای آگهی {{ $advertisement->title }}</span>
                    </td>
                    <td>
                        <span class="uk-text-meta">{{ $package->duration_in_days }} روز</span>
                        @if(!$giftUsed)
                            <span class="uk-text-meta uk-text-success">+ {{ $package->gift_duration_in_days }} روز هدیه</span>
                        @endif
                    </td>
                    <td>-</td>
                    <td>{{ number_format($transaction->amount) }}</td>
                </tr>
                </tbody>
            </table>
            @if(!$transaction->paid)
            <form action="{{ route('Zarinpal > Transaction > Pay', $transaction->id) }}">
                <div class="uk-child-width-1-2@m" uk-grid>
                    <div>
                        <label><input class="uk-checkbox" type="checkbox" required> قوانین و مقررات {{ env('APP_NAME') }} را خوانده و با آن موافقم.</label>
                    </div>
                    <div class="">
                        <button class="uk-button uk-width-1-1 uk-button-primary">
                            @if($transaction->amount == 0)
                                فعال سازی
                            @else
                                پرداخت
                            @endif
                        </button>
                    </div>
                </div>
            </form>
            @else
                <div class="uk-alert-primary" uk-alert>
                    <p style="direction: rtl; text-align: right">کاربر گرامی، پرداخت شما با شماره تراکنش {{ Helper::faNum($transaction->transaction_ref_id) }} در تاریخ {{ Helper::faNum(jdate($transaction->updated_at)->format('d-m-Y')) }} و ساعت {{ Helper::faNum(jdate($transaction->updated_at)->format('H:i:s')) }} صورت گرفته است.</p>
                </div>
            @endif
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
@endsection
