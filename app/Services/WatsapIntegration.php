<?php

namespace App\Services;

use App\Models\Booking;
use UltraMsg\WhatsAppApi;
use App\Models\Membership;
use App\Models\OrderPayment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentGetway;
use App\Models\PaymentGeteway;
use Illuminate\Support\Facades\DB;
use App\Models\SubscriptionPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use App\Services\contracts\PaymentInterface;


class WatsapIntegration
{
    public $client;
    public $object;
    public function __construct($object){
         $this->object = $object;
    }
    public function Process(){

    $ultramsg_token="m00v2yruhlgxvj87"; // Ultramsg.com token
    $instance_id="instance81647"; // Ultramsg.com instance id
    $client = new WhatsAppApi($ultramsg_token,$instance_id);

    $to="+20 100 559 0881";
    $body= $this->object;
    $api=$client->sendChatMessage($to,$body);
    print_r($api);

}
}
