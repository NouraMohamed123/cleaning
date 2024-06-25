<?php

use App\Models\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
if (!function_exists('upload')) {
function upload($avatar, $directory)
{
        $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
        $avatar->move($directory, $avatarName);
        return $avatarName;

}

// function isServiceInUserSubscription( $serviceId)
// {
//     $user = Auth::guard('app_users')->user();

//     if (!$user) {
//         return false;
//     }
//     $subscriptions = $user->subscription;
//     $subscriptionData = $user->subscription()->first(['expire_date', 'visit_count']);

//     if (!$subscriptions) {
//         return false;
//     }

//     if (!$subscriptions ||  $subscriptionData->expire_date < now()) {
//         return false;
//     }
//     foreach($subscriptions as $subscription){
//         if ( $subscriptionData->visit_count >= $subscription->visits) {
//             return response()->json(['error' => 'Visit count limit exceeded'], 422);
//         }
//         $subscriptionServices = $subscription->services;

//         foreach ($subscriptionServices as $service) {
//             // dd($serviceId);
//             if ($service->id == $serviceId) {
//                 return true;
//             }
//         }
//     }
//     return false;
// }
function isServiceInUserSubscription($serviceId)
{
    $user = Auth::guard('app_users')->user();

    if (!$user) {
        return false;
    }

    $subscriptions = $user->subscription()->where('expire_date', '>', now())->get();

    if ($subscriptions->isEmpty()) {
        return false;
    }

    foreach ($subscriptions as $subscription) {
        $pivotData = $subscription->pivot;

        if ($pivotData->visit_count == $subscription->visits) {
            return false;
            return response()->json(['error' => 'Visit count limit exceeded'], 422);
        }

        $subscriptionServices = $subscription->services;

        foreach ($subscriptionServices as $service) {
            if ($service->id == $serviceId) {
                return true;
            }
        }
    }

    return false;
}

}
  /////////
  if (!function_exists('checkCoupon')) {
    function checkCoupon($couponCode, $totalAmount)
    {
        $coupon = App\Models\Coupon::where('discount_code', $couponCode)->first();

        if (!$coupon) {
            return ['status' => false, 'message' => 'not exist'];
        }

        $currentDate = date('Y-m-d');
        if ($currentDate < $coupon->start_date || $currentDate > $coupon->end_date) {
            return ['status' => false, 'message' => 'date expired'];
        }

        if ($coupon->max_usage !== null && $coupon->max_usage <= 0) {
            return ['status' => false, 'message' => 'max usage reached'];
        }

        if ($coupon->max_discount_value !== null && $totalAmount > $coupon->max_discount_value) {
            return ['status' => false, 'message' => 'totalAmount greater than max discount value'];
        }

        // Decrement max_usage in the database
        if ($coupon->type == 'percentage') {
            $discount = (float) $coupon->discount_percentage;
            $priceAfterDiscount = $totalAmount - ($totalAmount * $discount);
        } else {
            $discount = (int) $coupon->discount;
            $priceAfterDiscount = $totalAmount - $discount;
        }

        return [
            'status' => true,
            'discount' => $discount,
            'price_after_discount' => $priceAfterDiscount,
            'id' => $coupon->id,
        ];
    }
}
if (!function_exists('sendFirbase')) {
    function sendFirbase(array $tokens, $title = null, $body = null, $clickActionUrl = null)
    {
        $tokens = array_values(array_filter(array_unique($tokens)));

        $notification = [
            'title' => !empty($title) ? $title : config('app.name') . ' Notification',
            'body' => $body,
            'click_action' => $clickActionUrl, // Add click action URL
        ];

        try {
            $headers = [
                'Authorization: key=' . env('API_ACCESS_KEY'),
                'Content-Type: application/json'
            ];

            $fields = [
                'registration_ids' => $tokens,
                'notification' => $notification,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            logger(json_encode($fields));
            $result = curl_exec($ch);
            $res = json_decode($result);
            curl_close($ch);

            if ($res && $res->failure) {
                throw new Exception("\n Notification Error: \n" . json_encode($res) . "\n Tokens: " . json_encode($tokens));
            }

            return $res;
        } catch (Exception $ex) {
            // Handle the exception
        }
    }
}
if (!function_exists('calculateRiyalsFromPoints')) {
    function calculateRiyalsFromPoints($userId)
{
    $points = Point::where('user_id', $userId)->sum('point');
    $pointsPerRiyal = 5000;
    $amountPerRiyal = 100;

    if ($points > 0) {
        $riyals = ($points / $pointsPerRiyal) * $amountPerRiyal;
        return $riyals;
    }

    return 0;
}
    }
