<?php

namespace App\Services;
use UltraMsg\WhatsAppApi;
class WatsapIntegration
{
    public $watsap;
    public $object;
    public function __construct($object){
         $this->object = $object;
    }
    public function Process(){

    $ultramsg_token="m00v2yruhlgxvj87"; // Ultramsg.com token
    $instance_id="instance81647"; // Ultramsg.com instance id
    $watsap = new WhatsAppApi($ultramsg_token,$instance_id);

    $to="+966 50 789 4367";
    $body= $this->object;
    $api=$watsap->sendChatMessage($to,$body);
    // print_r($api);

}
}
