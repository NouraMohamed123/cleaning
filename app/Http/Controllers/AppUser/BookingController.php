<?php

namespace App\Http\Controllers\AppUser;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\TabbyPayment;
use App\Services\TammaraPayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Notification;
use League\CommonMark\Extension\TableOfContents\TableOfContentsBuilder;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $tammara;
    public $tabby;
    public function __construct()
    {
          $this->tammara = new TammaraPayment();
          $this->tabby = new TabbyPayment();
    }
    public function userBookings()
    {

        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $bookings = Booking::where('user_id', $user->id)->get();
        return response()->json(['bookings' => $bookings], 200);
    }



    public function bookService(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'address' => 'required|string',
            'date' => 'required|date_format:m/d/Y H:i',
            'meter' => 'required|numeric',
            'status' => 'boolean',
            'payment'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $service = Service::findOrFail($request->service_id);


        // Calculate the total price: meter * service price
        $total_price = $request->meter * $service->price;
        $selectedDateTime = Carbon::createFromFormat('m/d/Y H:i', $request->date);

        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // $existingBooking = Booking::where('service_id', $request->service_id)
        //     ->where('date', $selectedDateTime->format('Y-m-d H:i:s'))->where('available',0)
        //     ->first();
        // if ($existingBooking) {
        //     return response()->json(['error' => 'This date and time slot are already booked. Please choose another.'], 422);
        // }

        // Create the booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'address' => $request->address,
            'date' => $selectedDateTime,
            'total_price' => $total_price,
            'status' => $request->has('status') ? $request->status : false,
            'booking_time'=>Carbon::now(),
        ]);
        if (!isServiceInUserSubscription($request->service_id)) {
            if($request->payment=='Tabby'){
            $order_data = [
                'amount'=> 1,
                'currency' => 'رس',
                'description'=> 'ok',
                'full_name'=> $booking->user->name,
                'buyer_phone'=>$booking->user->phone,
                'buyer_email' => 'ok@gmail.com',
                'address'=> 'Saudi Riyadh',
                'city' => 'Riyadh',
                'zip'=> '1234',
                'order_id'=>  $booking->id,
                'registered_since' => $booking->created_at,
                'loyalty_level'=> 0,
                'success-url'=> route('success-ur'),
                'cancel-ur' => route('cancel-ur'),
                'failure-ur' => route('failure-ur'),
                'items' => [
                    [
                        'title' => 'حجز خدمة',
                        'quantity' => 1,
                        'unit_price' => $total_price,
                        'category' => 'الخدمة',
                        ]
                    ],
                ];

            $payment = $this->tabby->createSession($order_data);

            $id = $payment->id;

            $redirect_url = $payment->configuration->available_products->installments[0]->web_url;

            return redirect($redirect_url);
        }elseif($request->payment=='Tammara'){
            $consumer = [
                'first_name' =>  $booking->user->name,
                'last_name' => $booking->user->name,
                'phone' => $booking->user->phone,
                'email' => $booking->user->email ?? 'test@test.com' ,
            ];

            $billing_address = [
                'first_name' => $booking->user->name,
                'last_name' =>  $booking->user->name,
                'line1' =>  $request->address??'Riyadh',
                'city' =>  $request->address??'Riyadh',
                'phone' => $booking->user->phone,
            ];

            $shipping_address = $billing_address;
                $order = [
                'order_num' =>869698,
                'total' => $booking->total_price,
                'notes' => 'notes',
                'discount_name' => 'discount coupon',
                'discount_amount' => 0,
                'vat_amount' => 0,
                'shipping_amount' => 0,
            ];
            $products[] = [
                'id' => $booking->service_id,
                'type'=> 'حجز خدمة',
                'name' =>  $booking->service->name,
                'sku' => 'SA-12436',
                'image_url' => $booking->service->photo,
                'quantity' => 1,
                'unit_price' => $booking->service->price,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'total' => $booking->service->price,
            ];

          dd( $this->tammara->paymentProcess($order ,$products, $consumer, $billing_address,$shipping_address)) ;
        }
        } else {

            $user = Auth::guard('app_users')->user();
            $subscriptions = $user->subscription()->where('expire_date', '>', now())->get();

            foreach ($subscriptions as $subscription) {
                //update limit
                $pivotData = $subscription->pivot;
                if ($pivotData->visit_count < $subscription->visits) {
                    $pivotData->visit_count++;
                    $pivotData->save();
                    break;
                }
            }
        }



        ;
        // Send notification when booking is created
        $adminUsers = User::where('roles_name', 'Admin')->get();
        foreach ($adminUsers as $adminUser) {
        Notification::send($adminUser, new BookingNotification($booking));
        }


        return response()->json(['message' => 'Booking created successfully', 'booking' => $booking], 201);
    }

    public function show(string $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json(['booking' => $booking], 200);
    }


    public function cancelBooking($id)
    {
        // Find the booking by ID
        $booking = Booking::find($id);

        // Check if the booking exists
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        // Get the authenticated user using the app_users guard
        $user = Auth::guard('app_users')->user();

        // Check if a user is authenticated and if the booking belongs to the user
        if (!$user || $booking->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Delete the booking
        $booking->delete();

        // Return success response
        return response()->json(['message' => 'Booking canceled successfully'], 200);
    }

    public function sucess(Request $request)
    {

       dd($request);
        $order = Order::find(1);

        $tabby_payemnt = $this->tabby->getSession($order->payment_id);

        if (isset($tabby_payemnt->payment) && $tabby_payemnt ->payment->status == "CLOSED") {

                $order->paid == true;
                $order->save();
        }


    }
    public function cancel(Request $request)
    {
        dd($request);
    }
    public function failure(Request $request)
    {
        dd($request);
    }
    public function tamaraResult(Request $request)
    {
       return  $this->tammara->calbackPayment($request);
    }
}
