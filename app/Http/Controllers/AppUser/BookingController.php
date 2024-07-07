<?php

namespace App\Http\Controllers\AppUser;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Service;
use App\Events\BookedEvent;
use Illuminate\Http\Request;
use App\Services\TabbyPayment;
use App\Services\paylinkPayment;
use App\Services\TammaraPayment;
use App\Services\WatsapIntegration;
use App\Http\Controllers\Controller;
use App\Models\ControlBooking;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AppUserBooking;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Notification;
use League\CommonMark\Extension\TableOfContents\TableOfContentsBuilder;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $paylink;
    public $tabby;
    public $tammara;
    public function __construct()
    {
        $this->paylink = new paylinkPayment();
        $this->tabby = new TabbyPayment();
        $this->tammara = new TammaraPayment();
    }
    public function userBookings()
    {

        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $bookings = Booking::with('service')->where('user_id', $user->id)->where('paid',1)->get();
        return response()->json(['bookings' => $bookings], 200);
    }

    public function getServiceDetails($serviceId)
    {

        $service = Service::with('optionTypes.options')->find($serviceId);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        // Format the data to include option types and options
        $serviceDetails = [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'option_types' => []
        ];

        foreach ($service->optionTypes as $optionType) {
            $options = $optionType->options->map(function ($option) {
                return [
                    'id' => $option->id,
                    'value' => $option->value,
                ];
            });

            $serviceDetails['option_types'][] = [
                'id' => $optionType->id,
                'name' => $optionType->name,
                'options' => $options,
            ];
        }

        return response()->json($serviceDetails);
    }


    // public function bookService(Request $request)
    // {
    //     // Validate the incoming request data
    //     $validator = Validator::make($request->all(), [
    //         'service_id' => 'required|exists:services,id',
    //         'address' => 'required|string',
    //         'date' => 'required|date_format:m-d-Y',
    //         'time' => 'required',
    //         'meter' => 'required|numeric',
    //         'status' => 'boolean',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }
    //     $service = Service::findOrFail($request->service_id);


    //     // Calculate the total price: meter * service price
    //     $total_price = $request->meter * $service->price;

    //     $user = Auth::guard('app_users')->user();
    //     if (!$user) {
    //         return response()->json(['error' => 'سجل الدخول اولا'], 401);
    //     }
    //     $requestedDate = Carbon::createFromFormat('m-d-Y', $request->date);
    //     if ($requestedDate->isPast()) {
    //         return response()->json(['error' => 'التاريخ الذي ادخلتة تاريخ قديم'], 422);
    //     }

    //     /////////////////////////


    //     $convertedDate = Carbon::createFromFormat('m-d-Y', $request->date)->format('Y-m-d');
    //     $startTime = Carbon::createFromFormat('h:i A', $request->time)->format('H:i:s');

    //     $existingBookings = Booking::where('service_id', $request->service_id)
    //         ->where('date', $convertedDate)
    //         ->get();

    //     if ($existingBookings->isNotEmpty()) {
    //         foreach ($existingBookings as $existingBooking) {
    //             $existingEndTime = Carbon::createFromFormat('H:i:s', $existingBooking->time)
    //                 ->addHours(4)
    //                 ->format('H:i:s');
    //             $bookingStart = Carbon::createFromFormat('H:i:s', $existingBooking->time);
    //             $bookingEnd = Carbon::createFromFormat('H:i:s', $existingEndTime);
    //             $desiredStart = Carbon::createFromFormat('H:i:s', $startTime)->addMinutes(1);
    //             $desiredEnd = $desiredStart->copy()->addHours(4);
    //             if (
    //                 ($desiredStart->between($bookingStart, $bookingEnd, true))

    //             ) {

    //                 return response()->json([
    //                     'error' => 'تم حجز هذه الخدمة بالفعل. يرجى اختيار وقت آخر وبعد 4 ساعات'
    //                 ], 422);
    //             }
    //         }
    //     }
    //     // Create the booking
    //     $booking = Booking::create([
    //         'user_id' => $user->id,
    //         'service_id' => $request->service_id,
    //         'address' => $request->address,
    //         'date' => $convertedDate,
    //         'time' => $startTime,
    //         'name' => $request->name ?? $user->name,
    //         'phone' => $request->phone ?? $user->phone,
    //         'total_price' => $total_price,
    //         'status' => $request->has('status') ? $request->status : false,

    //     ]);

    //     if (!isServiceInUserSubscription($request->service_id)) {

    //         if ($request->payment == 'Tabby') {
    //             $items = collect([]);
    //             $items->push([
    //                 'title' => 'title',
    //                 'quantity' => 2,
    //                 'unit_price' => 20,
    //                 'category' => 'Clothes',
    //             ]);;

    //             $order_data = [
    //                 'amount' =>  $total_price,
    //                 'currency' => 'SAR',
    //                 'description' => 'description',
    //                 'full_name' => $booking->user->name ?? 'user_name',
    //                 'buyer_phone' => $booking->user->phone ?? '9665252123',
    //                 // 'buyer_email' => 'card.success@tabby.ai',//this test
    //                 'buyer_email' =>  $booking->user->email ?? 'user@gmail.com',
    //                 'address' => 'Saudi Riyadh',
    //                 'city' => 'Riyadh',
    //                 'zip' => '1234',
    //                 'order_id' => "$booking->id",
    //                 'registered_since' => $booking->created_at,
    //                 'loyalty_level' => 0,
    //                 'success-url' => route('success-ur'),
    //                 'cancel-url' => route('cancel-ur'),
    //                 'failure-url' => route('failure-ur'),
    //                 'items' =>  $items,
    //             ];

    //             $payment = $this->tabby->createSession($order_data);

    //             $id = $payment->id;

    //             $redirect_url = $payment->configuration->available_products->installments[0]->web_url;
    //             return  $redirect_url;
    //         } elseif ($request->payment == 'Paylink') {

    //             $data = [
    //                 'amount' => $total_price,
    //                 'callBackUrl' => route('paylink-result'),
    //                 'clientEmail' => $booking->user->email ?? 'test@gmail.com',
    //                 'clientMobile' => $booking->user->phone ?? '9665252123',
    //                 'clientName' => $booking->user->name ?? 'user_name',
    //                 'note' => 'This invoice is for VIP client.',
    //                 'orderNumber' => $booking->id,
    //                 'products' => [
    //                     [
    //                         'description' => $booking->service->description ?? 'description',
    //                         'imageSrc' =>  $booking->service->photo,
    //                         'price' => $total_price ?? 1,
    //                         'qty' => 1,
    //                         'title' => $booking->service->name ?? 'title',
    //                     ],
    //                 ],
    //             ];


    //             return $this->paylink->paymentProcess($data);
    //         } elseif ($request->payment == 'Tammara') {
    //             $consumer = [
    //                 'first_name' =>  $booking->user->name,
    //                 'last_name' => $booking->user->name,
    //                 'phone' => $booking->user->phone,
    //                 'email' => $booking->user->email ?? 'test@test.com',
    //             ];

    //             $billing_address = [
    //                 'first_name' => $booking->user->name,
    //                 'last_name' =>  $booking->user->name,
    //                 'line1' =>  $request->address ?? 'Riyadh',
    //                 'city' =>  $request->address ?? 'Riyadh',
    //                 'phone' => $booking->user->phone,
    //             ];

    //             $shipping_address = $billing_address;
    //             $order = [
    //                 'order_num' =>$booking->id,
    //                 'total' => $booking->total_price,
    //                 'notes' => 'notes',
    //                 'discount_name' => 'discount coupon',
    //                 'discount_amount' => 0,
    //                 'vat_amount' => 0,
    //                 'shipping_amount' => 0,
    //             ];
    //             $products[] = [
    //                 'id' => $booking->service_id,
    //                 'type' => 'حجز خدمة',
    //                 'name' =>  $booking->service->name,
    //                 'sku' => 'SA-12436',
    //                 'image_url' => $booking->service->photo,
    //                 'quantity' => 1,
    //                 'unit_price' => $booking->service->price,
    //                 'discount_amount' => 0,
    //                 'tax_amount' => 0,
    //                 'total' => $booking->service->price,
    //             ];

    //             dd($this->tammara->paymentProcess($order, $products, $consumer, $billing_address, $shipping_address));
    //         } else {
    //             return response()->json(['message' => 'choose payment ',], 422);
    //         }
    //     } else {

    //         $user = Auth::guard('app_users')->user();
    //         $subscriptions = $user->subscription()->where('expire_date', '>', now())->get();

    //         foreach ($subscriptions as $subscription) {
    //             // dd($subscription);
    //             //update limit
    //             $pivotData = $subscription->pivot;
    //             if ($pivotData->visit_count < $subscription->visits) {
    //                 $pivotData->visit_count++;
    //                 $pivotData->save();
    //                 break;
    //             }
    //         }
    //     }
    //     return response()->json(['message' => 'عملية الحجز تمت بنجاح', 'booking' => $booking], 201);
    // }
    public function bookMultipleServices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'        => 'required|string',
            'date'           => 'required|date_format:m-d-Y',
            'time'           => 'required',
            'status'         => 'boolean',
            'area_id'=>'required|exists:areas,id',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'Please login first'], 401);
        }

        $requestedDate = Carbon::createFromFormat('m-d-Y', $request->date);
        if ($requestedDate->isPast()) {
            return response()->json(['error' => 'The entered date is in the past'], 422);
        }
        //     /////////////////////////
        $convertedDate = Carbon::createFromFormat('m-d-Y', $request->date)->format('Y-m-d');
        $startTime = Carbon::createFromFormat('h:i A', $request->time)->format('H:i:s');
        $carts = Cart::where('user_id', $user->id)->get();
        $items = [];
        $items_subscriptions = [];
        $filteredItems = [];
        $error = false;
        $subscription_flag = false;
        if ($carts->isEmpty()) {
            return response()->json([
                'error' => 'cart is empty'
            ], 422);
        }
        $existingDate = ControlBooking::where('date', $request->date)->first();
        if($existingDate){
            $existingOrders = Order::where('date', $request->date)->get();
            foreach ($existingOrders as $existingOrder) {
                if ($existingDate->max_number >= $existingOrder->count_booking) {
                    return response()->json(['message' => 'Booking is closed for this date']);
                }
            }
        }
        foreach ($carts as $cart) {
            $service = Service::where('id', $cart->service_id)->first();
            $existingBookings = Booking::where('service_id', $service->id)
                ->where('date', $convertedDate)
                ->where('paid', 1)
                ->get();

            if ($existingBookings->isNotEmpty()) {
                foreach ($existingBookings as $existingBooking) {
                    $existingEndTime = Carbon::createFromFormat('H:i:s', $existingBooking->time)
                        ->addHours(4)
                        ->format('H:i:s');
                    $bookingStart = Carbon::createFromFormat('H:i:s', $existingBooking->time);
                    $bookingEnd = Carbon::createFromFormat('H:i:s', $existingEndTime);
                    $desiredStart = Carbon::createFromFormat('H:i:s', $startTime)->addMinutes(1);
                    $desiredEnd = $desiredStart->copy()->addHours(4);

                    if ($desiredStart->between($bookingStart, $bookingEnd, true)) {
                        $error = true;
                        break;
                    }
                }

                if ($error) {
                    return response()->json([
                        'error' => 'تم حجز هذه الخدمة بالفعل. يرجى اختيار وقت آخر وبعد 4 ساعات'
                    ], 422);
                }
            }

            $cost = $cart->meters * $service->price;
            $booking = Booking::create([
                'user_id'     => $user->id,
                'service_id'  => $service->id,
                'address'     => $request->address,
                'date'        => $convertedDate,
                'time'        => $startTime,
                'name'        => $request->name ?? $user->name,
                'phone'       => $request->phone ?? $user->phone,
                'total_price' => $cost,
                'status'      => $request->has('status') ? $request->status : false,
            ]);

            if ($error) {
                return response()->json([
                    'error' => 'تم حجز هذه الخدمة بالفعل. يرجى اختيار وقت آخر وبعد 4 ساعات'
                ], 422);
            }

            if (isServiceInUserSubscription($service->id)) {

                $user = Auth::guard('app_users')->user();

                $subscriptions = $user->subscription()->where('expire_date', '>', now())->get();
                foreach ($subscriptions as $subscription) {
                    $pivotData = $subscription->pivot;
                    if ($pivotData->visit_count < $subscription->visits) {

                        if($subscription_flag == false){
                            $pivotData->visit_count++;
                        }
                        $pivotData->save();
                    }
                }
                $items_subscriptions[] = [
                    'id'    => $service->id,
                    'booked_id' => $booking->id,
                    'total' => $cost,
                ];
                $subscription_flag= true;
            }

            $items[] = [
                'id'    => $service->id,
                'booked_id' => $booking->id,
                'total' => $cost,
            ];
            $filteredItems = array_filter($items, function ($item) use ($items_subscriptions) {
                return !in_array($item['booked_id'], array_column($items_subscriptions, 'booked_id'));
            });


        }
        //  dd($items,$items_subscriptions,$filteredItems);
         if (!empty($items_subscriptions)) {
            $totalCost = collect($items_subscriptions)->sum('total') ?? 0.0;
            $order = Order::create([
                'user_id'     => $user->id,
                'total_price' => $totalCost,
                'address'     => $request->address,
                'date'        => $convertedDate,
                'time'        => $startTime,
                'area_id'=>$request->area_id,
            ]);

            foreach ($items_subscriptions as $item) {
                $booking = Booking::where('id', $item['booked_id'])->first();
                $booking->paid = 1;
                $booking->save();
                $booking->order_id = $order->id;
                $booking->save();
            }
            if(empty($filteredItems)){
             Cart::where('user_id', $user->id)->delete();
             $data =  [
                'name' => $order->user->name,
                'address' => $order->address,
                'date' => $order->date,
                'time' => $order->time,
                'area' => $order->area->name,
                'city' => $order->area->city->name,
                'message' => ' لديك حجز جديد  ليوزر مشترك ',
            ];
            $watsap =   new WatsapIntegration($data);
            $watsap->Process();
             return response()->json(['message' => 'عملية الحجز تمت بنجاح'], 201);
            }

        }

      $totalCost = collect($filteredItems)->sum('total') ?? 0.0;
      if ($request->has('coupon_code') && !empty($request->coupon_code)) {
        $coupon_data = checkCoupon($request->coupon_code, $totalCost);
        if ($coupon_data && $coupon_data['status'] == true) {
            $totalCost = $coupon_data['price_after_discount'];
        } else {
            return response()->json(['status' => false, 'message' => $coupon_data['message']], 310);
        }

    }
    if ($request->points == true) {
        if ($riyals = calculateRiyalsFromPoints($user->id) > 0) {

            $totalCost -= $riyals;
        }
    }
        $order = Order::create([
            'user_id'     => $user->id,
            'total_price' => $totalCost,
            'address'     => $request->address,
            'date'        => $convertedDate,
            'time'        => $startTime,
            'area_id'=>$request->area_id,
            'coupon_id' => $coupon_data['id'] ?? 0,
        ]);
        $bookings = [];
        foreach ($filteredItems as $item) {
            $booking = Booking::where('id', $item['booked_id'])->first();
            $booking->order_id = $order->id;
            $booking->save();
        }
        if ($request->payment == 'Tabby') {
            $items = collect([]);
            $items->push([
                'title' => 'title',
                'quantity' => 1,
                'unit_price' => 20,
                'category' => 'Clothes',
            ]);

            $order_data = [
                'amount' => $totalCost,
                'currency' => 'SAR',
                'description' => 'description',
                'full_name' =>  $order->user->name ?? 'user_name',
                'buyer_phone' =>  $order->user->phone ?? '9665252123',
                //  'buyer_email' => 'card.success@tabby.ai',//this test
                'buyer_email' =>   $order->user->email ?? 'user@gmail.com',
                'address' => 'Saudi Riyadh',
                'city' => 'Riyadh',
                'zip' => '1234',
                'order_id' => " $order->id",
                'registered_since' =>  $order->created_at,
                'loyalty_level' => 0,
                'success-url' => route('success-ur'),
                'cancel-url' => route('cancel-ur'),
                'failure-url' => route('failure-ur'),
                'items' =>  $items,
            ];

            $payment = $this->tabby->createSession($order_data);

            $id = $payment->id;

            $redirect_url = $payment->configuration->available_products->installments[0]->web_url;
            return  $redirect_url;
        } elseif ($request->payment == 'Paylink') {

            $data = [
                'amount' => $totalCost,
                'callBackUrl' => route('paylink-result'),
                'clientEmail' =>  $order->user->email ?? 'test@gmail.com',
                'clientMobile' =>  $order->user->phone ?? '9665252123',
                'clientName' =>  $order->user->name ?? 'user_name',
                'note' => 'This invoice is for VIP client.',
                'orderNumber' =>  $order->id,
                'products' => [
                    [
                        'description' => 'description',
                        'imageSrc' =>  'image',
                        'price' =>  1,
                        'qty' => 1,
                        'title' =>  'title',
                    ],
                ],
            ];


            return $this->paylink->paymentProcess($data);
        }
        //  elseif ($request->payment == 'Tammara') {
        //     $consumer = [
        //         'first_name' =>  $order->user->name,
        //         'last_name' => $order->user->name,
        //         'phone' => $order->user->phone,
        //         'email' => $order->user->email ?? 'test@test.com',
        //     ];

        //     $billing_address = [
        //         'first_name' => $order->user->name,
        //         'last_name' =>  $order->user->name,
        //         'line1' =>  $request->address ?? 'Riyadh',
        //         'city' =>  $request->address ?? 'Riyadh',
        //         'phone' => $order->user->phone,
        //     ];

        //     $shipping_address = $billing_address;
        //     $order = [
        //         'order_num' =>$order->id,
        //         'total' =>  $totalCost,
        //         'notes' => 'notes',
        //         'discount_name' => 'discount coupon',
        //         'discount_amount' => 0,
        //         'vat_amount' => 0,
        //         'shipping_amount' => 0,
        //     ];
        //     $products[] = [
        //         'id' => $booking->service_id,
        //         'type' => 'حجز خدمة',
        //         'name' =>  $booking->service->name,
        //         'sku' => 'SA-12436',
        //         'image_url' => $booking->service->photo,
        //         'quantity' => 1,
        //         'unit_price' => $booking->service->price,
        //         'discount_amount' => 0,
        //         'tax_amount' => 0,
        //         'total' => $booking->service->price,
        //     ];

        //     dd($this->tammara->paymentProcess($order, $products, $consumer, $billing_address, $shipping_address));
        // }
        else {
            return response()->json(['message' => 'choose payment ',], 422);
        }

        return response()->json(['message' => 'عملية الحجز تمت بنجاح'], 201);
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

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        $user = Auth::guard('app_users')->user();
        if (!$user || $booking->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $booking->delete();
        return response()->json(['message' => 'Booking canceled successfully'], 200);
    }
    public function checkCoupon(Request $request)
    {
        return checkCoupon($request->couponCode, $request->totalAmount);
    }
    public function sucess(Request $request)
    {
        return   $this->tabby->calbackPayment($request);
    }
    public function cancel(Request $request)
    {
        return response()->json(["error" => 'error', 'Data' => 'payment canceld'], 404);
    }
    public function failure(Request $request)
    {
        return response()->json(["error" => 'error', 'Data' => 'payment failure'], 404);
    }
    public function paylinkResult(Request $request)
    {

        return   $this->paylink->calbackPayment($request);
    }

}
