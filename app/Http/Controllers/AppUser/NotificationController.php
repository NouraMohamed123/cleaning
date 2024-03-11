<?php

namespace App\Http\Controllers\APPUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function NotificationRead($type){
        if($type =='member'){
            $notifications = Auth::guard('app_users')->user()->notifications->where('type','App\Notifications\MembershipNotification')->get();
        }elseif($type =='booking'){
            $notifications = Auth::guard('app_users')->user()->notifications->where('type','App\Notifications\BookingNotification');
        }elseif($type =='register'){
            $notifications = Auth::guard('app_users')->user()->notifications->where('type','App\Notifications\UserRegisteredNotification');
        }

        return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
    }
    public function MarkASRead(){
     $notifications  =   Auth::guard('app_users')->user()->notifications->markAsRead();
        return response()->json(['isSuccess' => true], 200);
    }
    public function Clear(){
        $notifications  =   Auth::guard('app_users')->user()->notifications()->delete();
        return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
    }
}
