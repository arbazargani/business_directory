<?php

namespace App\Http\Controllers;

use App\Helpers\MelliPayamakDriver;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;

class LogController extends Controller
{
    public static function insert($message, $type, $author = null) {
        $log = new Log();
        $log->user_id = $author;
        $log->type = $type;
        $log->content = $message;
        $log->save();
        return $log->id;
    }

    public static function sendSMS($log_id, $phone_number) {
        $log = Log::find($log_id);
        if (!is_null($log)) {
            return MelliPayamakDriver::sendText($phone_number, $log->content);
        }
        return false;
    }

    public static function SendLoginSMS($user_id) {
        $user = User::find($user_id);
        $date = \Morilog\Jalali\CalendarUtils::convertNumbers(jdate()->forge(now())->format('Y/m/d'));
        $time = \Morilog\Jalali\CalendarUtils::convertNumbers(jdate()->forge(now())->format('H:i:s'));
        $ip = \Request::ip();
        $message = <<<EOD
        کاربر گرامی، یک ورود به حساب کاربری شما صورت گرفت.
        $date $time
        ip: $ip
        ronaghagency.ir
        EOD;
        if (!is_null($user)) {
            return MelliPayamakDriver::sendText($user->phone_number, $message);
        }
        return false;
    }

    public static function SendRegisterSMS($user_id) {
        $user = User::find($user_id);
        $date = \Morilog\Jalali\CalendarUtils::convertNumbers(jdate()->forge(now())->format('Y/m/d'));
        $time = \Morilog\Jalali\CalendarUtils::convertNumbers(jdate()->forge(now())->format('H:i:s'));
        $ip = \Request::ip();
        $phone = $user->phone_number;
        $message = <<<EOD
        کاربر گرامی، به رونق خوش آمدید، نام کاربری شما $phone می‌باشد.
        $date $time
        ronaghagency.ir
        EOD;
        if (!is_null($user)) {
            return MelliPayamakDriver::sendText($user->phone_number, $message);
        }
        return false;
    }
}
