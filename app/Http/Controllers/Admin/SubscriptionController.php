<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all subscriptions
        $subscriptions = Subscription::with('services')->paginate($request->get('per_page', 50));

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


    public function createSubscriptions(Request $request)
    {

        // Validate the input data
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'name' => 'required',
            'visits' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'service_ids.*' => 'required|exists:services,id', // Ensure each service ID exists in the services table
        ]);

        // Start a database transaction
        DB::beginTransaction();


        // Create a new subscription
        $subscription = Subscription::create([
            'name' => $request->name,
            'description' => $request->description,
            'visits' => $request->visits,
            'price' => $request->price,
            'duration' => $request->duration,
            'status' => $request->status ? 'active' : 'inactive'
        ]);

        // Attach services to the subscription
        foreach ($request->service_ids as $serviceId) {
            $subscription->services()->attach($serviceId);
        }
        // Eager load the associated services
        $subscription->load('services');
        // Commit the transaction
        DB::commit();

        // Return success response
        return response()->json([
            'message' => 'Subscription created successfully with selected services.',
            'subscription' => $subscription
        ], 200);
    }


    public function updateSubscriptionStatus(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive', // Validate the new status value
        ]);

        // Retrieve the subscription by its ID
        $subscription = Subscription::findOrFail($id);

        // Eager load the associated services
        $subscription->load('services');
        // Update the status
        $subscription->status = $request->status;
        $subscription->save();

        // Return success response
        return response()->json([
            'message' => 'Subscription status updated successfully.',
            'subscription' => $subscription
        ], 200);
    }
    public function updateSubscription(Request $request, $Id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'visits' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'service_ids.*' => 'required|exists:services,id', // Ensure each service ID exists in the services table
        ]);

        // Retrieve the subscription by its ID
        $subscription = Subscription::findOrFail($Id);

        // Update the subscription data
        $subscription->update([
            'name' => $request->name,
            'description' => $request->description,
            'visits' => $request->visits,
            'price' => $request->price,
            'duration' => $request->duration,
            'status' => $request->status,
        ]);

        // Sync the attached services
        foreach ($request->service_ids as $serviceId) {
         $subscription->services()->sync($serviceId);
        }
        // Eager load the associated services
         $subscription->load('services');

        // Return success response
        return response()->json([
            'message' => 'Subscription updated successfully.',
            'subscription' => $subscription
        ], 200);
    }

    public function getSubscriptionCount()
    {
        $count = Subscription::count();

        return response()->json([
            "successful" => true,
            "message" => "عملية العرض تمت بنجاح",
            'data' => $count
        ]);
    }
    public function deleteSubscription($id)
{
    try {
        // Retrieve the subscription by its ID
        $subscription = Subscription::findOrFail($id);
        if(!$subscription) {
            return response()->json(['error' => 'subscription not found'], 422);
        }

        $subscription->delete();

        return response()->json(['message' => 'Subscription deleted successfully'], 200);
    } catch (\Exception $e) {
        // If the subscription is not found or any other error occurs
        return response()->json(['error' => 'Failed to delete subscription.'], 500);
    }
}
}
