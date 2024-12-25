<?php
namespace App\Helpers;
use Twilio\Rest\Client;
use Illuminate\Support\Str;

class Helpers{

    public static function send_sms($phone,$message){
        $account_sid = getenv('TWILIO_SID');
        $auth_token = getenv('TWILIO_TOKEN');
        $twilio_number = getenv('TWILIO_FROM');
        $sms_num='';
        if(Str::contains($phone, 'itsolutionstuff.com')){
            $sms_num=$phone;
        }else{
            $sms_num='+88'.$phone;
        }
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $sms_num,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
    }

}