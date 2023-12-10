<?php

namespace App\Http\Controllers;

use App\Helpers\MelliPayamakDriver;
use App\Models\Advertisement;
use App\Models\Comment;
use App\Models\IranCity;
use App\Models\IranProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function AdsLevelLottery()
    {
        $ads = Advertisement::all()->pluck('id')->toArray();
        shuffle($ads);
        for ($i = 0; $i < 4; $i ++) {
            Advertisement::find($ads[$i])->update([
                'ad_level' => 'comercial'
            ]);
        }
    }

    public function AdsLottery()
    {
        $ads = Advertisement::all()->pluck('id')->toArray();
        shuffle($ads);
        return Advertisement::find($ads[0]);
    }

    public function citiesLottery()
    {
        $ads = IranCity::all()->pluck('id')->toArray();
        shuffle($ads);
        return IranCity::find($ads[0]);
    }

    public function provincesLottery()
    {
        $ads = IranProvince::all()->pluck('id')->toArray();
        shuffle($ads);
        return IranProvince::find($ads[0]);
    }

    public function FakeAds()
    {
        $ad_levels = ['basic', 'commercial'];
        $business_categories = ['کافی شاپ', 'رستوران', 'فنی و مهندسی', 'آموزشی'];
        for ($i = 1; $i <= 200; $i++) {
            $province = $this->provincesLottery();
            $city = $this->citiesLottery();

            $ad = new Advertisement();
            $ad->title = "کسب و کار آزمایشی شماره $i";
            $ad->desc = "این نیز توضیحی آزمایشی در مورد کسب و کار من است";
            $ad->confirmed = 1;
            $ad->ad_level = $ad_levels[rand(1,2)-1];
            $ad->user_id = 1;
            $ad->published_at = now();
            $ad->fullname = Auth::user()->name;
            $ad->phone = Auth::user()->phone_number;
            $ad->business_name = 'asdahjhjasd';
            $ad->business_categories = json_encode($business_categories[rand(1,4)-1]);
            $ad->work_hours = json_encode([10, 20]);
            $ad->off_days = json_encode(["thursday","friday"]);
            $ad->business_number = Auth::user()->phone_number;
            $ad->business_images = '["uploads\/1\/1-\u0622\u0645\u0648\u0632\u0634\u06af\u0627\u0647-\u06af\u0631\u06cc\u0645-\u0633\u06cc\u0646\u0645\u0627\u06cc\u06cc-\u0645\u062d\u062a\u0634\u0645.jpg","uploads\/1\/2-\u0622\u0645\u0648\u0632\u0634\u06af\u0627\u0647-\u06af\u0631\u06cc\u0645-\u0633\u06cc\u0646\u0645\u0627\u06cc\u06cc-\u0645\u062d\u062a\u0634\u0645.jpg","uploads\/1\/3-\u0622\u0645\u0648\u0632\u0634\u06af\u0627\u0647-\u06af\u0631\u06cc\u0645-\u0633\u06cc\u0646\u0645\u0627\u06cc\u06cc-\u0645\u062d\u062a\u0634\u0645.jpg","uploads\/1\/4-\u0622\u0645\u0648\u0632\u0634\u06af\u0627\u0647-\u06af\u0631\u06cc\u0645-\u0633\u06cc\u0646\u0645\u0627\u06cc\u06cc-\u0645\u062d\u062a\u0634\u0645.jpg"]';
            $ad->province = $province->name;
            $ad->iran_province_id = $province->id;
            $ad->city = $city->name;
            $ad->iran_city_id = $city->id;
            $ad->longitude = '51.213232001213186';
            $ad->latitude = '35.74562734253233';
            $ad->save();
        }
    }

    public function FakeComments()
    {
        for ($i = 0; $i <= 300; $i++) {
            $c = new Comment();
            $c->advertisement_id = $this->AdsLottery()->id;
            $c->user_id = Auth::id();
            $c->content = "این یک نظر آزمایشی است و این نظر شماره $i است.";
            $c->active = true;
            $c->save();
        }
    }

    public function Test()
    {
//        $i = MelliPayamakDriver::otp('09209203656');
        $i = MelliPayamakDriver::sendText('09128026221', 'خوش آمدید، ronaghagency.ir - رونق');
        dd($i);
    }
}
