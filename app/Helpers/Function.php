<?php

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
        ];
    }
}
