<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Membership;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\SubscriptionPayment;
use App\Http\Controllers\Controller;
use App\Models\AppUsers;

class ReportsController extends Controller
{
    public function all_orders()
    {
        $booked =  Booking::with('service','user')->get();
        return  $booked;
    }
    public function all_subscription()
    {
        $membership =  AppUsers::with('subscription')->get();
        return  $membership;
    }
    public function all_payments()
    {
        $payments = OrderPayment::with('booking')->latest()->get();
        return response()->json(['data'=> $payments], 200);
    }
    public function all_payments_subscription()
    {
        $payments = SubscriptionPayment::with('membership.user','membership.subscription')->latest()->get();
        return response()->json(['data'=> $payments], 200);
    }
}
