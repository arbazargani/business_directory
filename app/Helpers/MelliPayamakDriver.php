<?php

namespace App\Helpers;
use Melipayamak\MelipayamakApi;

class MelliPayamakDriver
{
    public static function otp($receiver)
    {
        $url = 'https://console.melipayamak.com/api/send/otp/'.env('MELLIPAYAMAK_API_KEY');
        // $data = ['to' => $receiver, 'bodyId' => 179298];
        $data = ['to' => $receiver, 'bodyId' => 203710];
        $data_string = json_encode($data);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ]);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        // to debug
        if(curl_errno($ch)){
            echo 'Curl error: ' . curl_error($ch);
        }
        return $result;
    }
    public static function otpSoap($receiver) {
        $username = '09209203656';
        $password = '5gab86';
        $api = new MelipayamakApi($username,$password);
        $smsSoap= $api->sms('soap');
        $to = '09123456789';
        $res = $smsSoap->sendByBaseNumber([1234], $receiver, 179298);
        return $res;
    }
    public static function sendText($receiver, $content)
    {
        // $primaryNumber = '50004001412217';
        // $primaryNumber = '9820001100';
        $primaryNumber = '20001100';
        $url = 'https://console.melipayamak.com/api/send/simple/'.env('MELLIPAYAMAK_API_KEY');
        $data = ['from' => $primaryNumber, 'to' => $receiver, 'text' => $content];
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,[
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ]);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        // to debug
         if(curl_errno($ch)){
             echo 'Curl error: ' . curl_error($ch);
         }
         return $result;
    }

}
