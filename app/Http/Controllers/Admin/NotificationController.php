<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function NotificationRead(){
        $notifications = Auth::guard('users')->user()->notifications;
        return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
    }
    public function MarkASRead(){
        if(Auth::guard('users')->user()->notifications){
            $notifications  =   Auth::guard('users')->user()->notifications->markAsRead();

            return response()->json(['isSuccess' => true], 200);
        }

    }
    public function Clear(){

        if(Auth::guard('users')->user()->notifications){
            $notifications  =   Auth::guard('users')->user()->notifications()->delete();
            return response()->json(['isSuccess' => true,'data'=> $notifications ], 200);
        }

        return response()->json(['isSuccess' => false,'error' => 'user it has no notification'], 200);
    }
}
