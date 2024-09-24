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
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:prepared,received,canceled',  // Validate status against allowed values
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        $booking->status = $request->status;
        $booking->paid =  $request->status == 'received' ? 1:0;
        $booking->save();
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
