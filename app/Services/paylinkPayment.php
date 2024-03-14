<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\PaymentGetway;
use App\Models\PaymentGeteway;
use Illuminate\Support\Facades\Config;
use App\Services\contracts\PaymentInterface;
use Illuminate\Support\Facades\Http;


class paylinkPayment
{
    public $client;
    public function __construct()
    {

        // $paylink = PaymentGetway::where([
        //     ['keyword', 'paylink'],
        // ])->first();
        // $paylinkConf = json_decode($paylink->information, true);
        // Config::set('services.paylink.pk_test ',$paylinkConf["app_id"]);
        // Config::set('services.paylink.app_secret  ',$paylinkConf["app_secret"]);


        Config::set('services.paylink.app_id','APP_ID_1710162901464');
        Config::set('services.paylink.app_secret','f29394fd-37fd-3ee7-a4f7-ea6014a24146');
        $client = new \Paylink\Client([
            'vendorId'  =>  'APP_ID_1123453311',
            'vendorSecret'  =>  '0662abb5-13c7-38ab-cd12-236e58f43766',

        ]);
        $this->client = $client;
    }
    public function paymentProcess($data)
    {

        $response =  $this->client->createInvoice($data);
       return    $response['mobileUrl'];
    }


    public function calbackPayment(Request $request)
    {
        $response =  $this->client->getInvoice($request->transactionNo);
        dd( $response);
    }
}
