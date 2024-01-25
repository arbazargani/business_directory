<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ZarinpalController extends Controller
{
    public $merchantID = "24f913f2-2ba9-4de3-9392-23be97a1182b";
    public $startPayUrl = "https://www.zarinpal.com/pg/StartPay/";

    public function Pay(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->paid !== 0 && $transaction->transaction_ref_id !== '') {
            return redirect()->route('Advertiser > Advertisement > Pay Confirm', $transaction->advertisement_id);
        }
        $transaction_info = json_decode($transaction->transaction_info, true);
        $curl = curl_init();
        $data = json_encode([
            "merchant_id" => $this->merchantID,
            "amount" => (int) $transaction->amount,
            "currency" => "IRT",
            "callback_url" => route('Zarinpal > Transaction > Callback'),
            "description" => "پکیج {$transaction->package->name} برای آگهی {$transaction->advertisement->title}",
            "metadata" => [
                "order_id" => (string) $transaction->id,
                "mobile" => $transaction->advertisement->user->phone_number
            ],
        ]);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.zarinpal.com/pg/v4/payment/request.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        if (isset($response->data->code) && $response->data->code === 100 && isset($response->data->authority)) {
            $transaction_info['authority'] = $response->data->authority;
            $transaction->where('id', $transaction->id)->update([
                'transaction_info' => json_encode($transaction_info)
            ]);
            return redirect()->away("{$this->startPayUrl}{$response->data->authority}");
        } else {
//            return $response;
            return 'خطا در پرداخت ...';
        }
    }

    public function Callback(Request $request)
    {
        if ($request->has('Authority') && $request->has('Status') && $request->get('Status') == 'OK') {
            return $this->Verify($request->get('Authority'));
        } else {
//            return $request;
            return 'خطای بازگشتی از درگاه پرداخت ...';
        }
    }
    public function Verify($authority)
    {
        $transaction = Transaction::whereJsonContains('transaction_info->authority', $authority)->first();
        $transaction_info = json_decode($transaction->transaction_info, true);
        $amount = $transaction->amount;
        $curl = curl_init();
        $data = json_encode([
          "merchant_id" => $this->merchantID,
          "amount" => $amount,
          "authority" => $authority
        ]);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        if (isset($response->data->code) && ($response->data->code === 100 || $response->data->code === 101)) {

            $transaction_info['message'] = $response->data->message;
            $transaction_info['card_hash'] = $response->data->card_hash;
            $transaction_info['card_pan'] = $response->data->card_pan;
            $transaction_info['ref_id'] = $response->data->ref_id;
            $transaction_info['message'] = $response->data->message;
            $transaction_info['fee_type'] = $response->data->fee_type;
            $transaction_info['fee'] = $response->data->fee;
            Transaction::where('id', $transaction->id)->update([
                'paid' => 1,
                'transaction_info' => json_encode($transaction_info),
                'transaction_ref_id' => $response->data->ref_id
            ]);


            $package = Package::find($transaction->package_id);
            $advertisement = $transaction->advertisement;
            $user_advertisements = Advertisement::where('user_id', $advertisement->user_id)->pluck('id')->toArray();
            $giftUsed = 1;
            $days_of_ad = $package->duration_in_days;
            if ($package->has_gift) {
                $giftUsed = Transaction::where('package_id', $package->id)
                    ->where('paid', 1)
                    ->whereIn('advertisement_id', $user_advertisements)
                    ->count();
                $days_of_ad = ($giftUsed == 0)
                    ? $package->duration_in_days + $package->gift_duration_in_days
                    : $package->duration_in_days;
            }
            $exp_date = Carbon::today()->addDays($days_of_ad);

            Advertisement::where('id', $transaction->advertisement_id)->update([
                'ad_level' => 'commercial',
                'transaction_id' => $transaction->id,
                'expires_at' => $exp_date

            ]);
            return redirect()->route('Advertiser > Advertisement > Pay Confirm', $advertisement->id);
        } else {
//            return $response;
            return 'خطای بازگشتی از درگاه پرداخت ...';
        }
    }
}
