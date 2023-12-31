<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;
use Twilio\Rest\Client;

class OTPController extends Controller
{
    public function generateOTP()
    {
        $otp = rand(100000, 999999);

        return $otp;
    }

    public function sendOTP(Request $request)
    {
        $otp = $this->generateOTP();
        $phoneNumber = $request->input('phone_number');

        $this->sendSMS($phoneNumber, "Your OTP is: $otp");

        return response()->json(['message' => 'OTP sent successfully']);
    }

    private function sendSMS($to, $message)
    {
        try{

            $TWILIO_ACCOUNT_SID = env("TWILIO_ACCOUNT_SID");
            $TWILIO_AUTH_TOKEN = env("TWILIO_AUTH_TOKEN");
            $TWILIO_FROM_PHONE_NUMBER = env("TWILIO_FROM_PHONE_NUMBER");

            $client = new Client($TWILIO_ACCOUNT_SID,$TWILIO_AUTH_TOKEN);
            $client->messages->create('+91'.$to,[
                'from' => $TWILIO_FROM_PHONE_NUMBER,
                'body' => $message,
            ]);

        }catch(Throwable $th){
            return response()->json($th);
        }
    }

}
