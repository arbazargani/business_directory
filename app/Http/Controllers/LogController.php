<?php

namespace App\Http\Controllers;

use App\Helpers\MelliPayamakDriver;
use Illuminate\Http\Request;
use App\Models\Log;

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
}
