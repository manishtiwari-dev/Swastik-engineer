<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class SmsServices
{
    public static function SendSMS($receiver_no,$msg)
    {
        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $from_number = getenv("VALID_TWILIO_NUMBER");
        
            $client = new Client($account_sid, $auth_token);
            
            $client->messages->create($receiver_no, [
                'from' => $from_number,
                'body' => $msg
            ]);

           return '';

        } catch (Exception $e) {
            // dd($e->getMessage());
        }
    }
}
