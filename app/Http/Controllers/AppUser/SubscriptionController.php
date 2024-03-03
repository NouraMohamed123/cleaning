<?php

namespace App\Http\Controllers\AppUser;

use Carbon\Carbon;
use App\Models\AppUsers;
use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\MembershipNotification;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        // Retrieve all subscriptions
        $subscriptions = Subscription::with('services')->get();

        // Return response with subscriptions
        return response()->json([
            'subscriptions' => $subscriptions
        ], 200);
    }
    public function show($Id)
    {
        // Retrieve the subscription by its ID
        $subscription = Subscription::with('services')->findOrFail($Id);

        // Return response with the subscription
        return response()->json([
            'subscription' => $subscription
        ], 200);
    }
   public function booking(Request $request){
    $validatedData = $request->validate([
        'subscription_id' => 'required|exists:subscriptions,id',
    ]);
    $user = Auth::guard('app_users')->user();
         $subscription = Subscription::find($request->subscription_id);
        $duration = $subscription->duration;

        $membership = new Membership();
        $membership->user_id = $user->id;
        $membership->subscription_id = $request->subscription_id;
        $membership->expire_date = Carbon::now()->addDays($duration);
        $membership->save();
        $adminUsers = User::where('roles_name', 'admin')->get();

    // Dispatch the notification to admin users
    foreach ($adminUsers as $adminUser) {
        $adminUser->notify(new MembershipNotification($membership));
    }

        ////////payment
        return response()->json(['message' => 'you subscripe successfully.'], 200);
   }
    public function requestVisit(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        // Retrieve the subscription
        $subscription = Subscription::findOrFail($validatedData['subscription_id']);

        // Check if the subscription is expired
        if ($subscription->isExpired()) {
            return response()->json(['message' => 'Subscription has expired.'], 400);
        }

        // Check if the visit limit is reached
        if ($subscription->isVisitLimitReached()) {
            return response()->json(['message' => 'Visit limit has been reached for this subscription.'], 400);
        }

        // Increment the visit count for the subscription
        $subscription->visits++;
        $subscription->save();

        // Return a success message
        return response()->json(['message' => 'Visit requested successfully.'], 200);
    }
  public function userSuscriptions(){
    $user = Auth::guard('app_users')->user();
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
    $suscriptions = $user->subscription;

    return response()->json(['data' => $suscriptions], 200);
  }
}
