<?php

namespace App\Http\Controllers\APPUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function NotificationRead(){
        if(Auth::guard('app_users')->user()->notifications){
        $notifications = Auth::guard('app_users')->user()->notifications;
        }
        return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
    }
    public function MarkASRead(){
        if(Auth::guard('app_users')->user()->notifications){
     $notifications  =   Auth::guard('app_users')->user()->notifications->markAsRead();
        return response()->json(['isSuccess' => true], 200);
        }
        return response()->json(['isSuccess' => false], 200);
    }
    public function Clear(){
        if(Auth::guard('app_users')->user()->notifications){
        $notifications  =   Auth::guard('app_users')->user()->notifications()->delete();
        return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
        }
        return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
    }
}
