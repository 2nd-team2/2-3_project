<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function getToken()
    {
        $client = new Client();
        $response = $client->request('POST', 'https://api.iamport.kr/users/getToken', [
            'form_params' => [
                'imp_key' => env('5722606507315822'), // 아임포트 REST API 키
                'imp_secret' => env('L4truon7itpKEmjmCGDEGnFuu1q6ZNuKAsoyGQvmzovy19vmSrrGyT33gQ7G1v03tL0UejWiZrhOEZlo') // 아임포트 REST API 시크릿
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return $body['response']['access_token'];
    }

    public function payment(Request $request)
    {
        $token = $this->getToken();

        $client = new Client();
        $response = $client->request('POST', 'https://api.iamport.kr/payments/prepare', [
            'headers' => [
                'Authorization' => $token
            ],
            'form_params' => [
                'merchant_uid' => $request->merchant_uid,
                'amount' => $request->amount
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
