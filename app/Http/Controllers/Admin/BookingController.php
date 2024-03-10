<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $booking = Booking::paginate($request->get('per_page', 50));
        return response()->json(['message' => 'all booking', 'booking' => $booking], 201);
    }
    public function show($id)
{
    // Retrieve the booking by its ID
    $booking = Booking::find($id);

    // Check if the booking exists
    if (!$booking) {
        return response()->json(['error' => 'Booking not found'], 404);
    }

    // Return the booking details
    return response()->json(['booking' => $booking], 200);
}

    public function changeBookingStatus(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Get the authenticated user using the admin guard
        $admin = Auth()->user();

        // Check if a user is authenticated and if the user has admin role
        if (!$admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Find the booking by ID
        $booking = Booking::find($id);

        // Check if the booking exists
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        // Update the booking status
        $booking->status = $request->status;
        $booking->save();
        

        // Return success response with the updated booking
        return response()->json(['message' => 'Booking status updated successfully', 'booking' => $booking], 200);
    }
    public function getBookingCount()
    {
        $count = Booking::count();

        return response()->json([
            "successful" => true,
            "message" => "عملية العرض تمت بنجاح",
            'data' => $count
        ]);
    }
}
