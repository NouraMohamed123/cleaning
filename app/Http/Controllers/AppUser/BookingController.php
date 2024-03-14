<?php

namespace App\Http\Controllers\AppUser;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Events\BookedEvent;
use Illuminate\Http\Request;
use App\Services\TabbyPayment;
use App\Services\TammaraPayment;
use App\Http\Controllers\Controller;
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
            // 'date' => 'required|date_format:m-d-Y H:i',
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
        // $selectedDateTime = Carbon::createFromFormat('m-d-Y H:i', $request->date);

        $user = Auth::guard('app_users')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // $existingBooking = Booking::where('service_id', $request->service_id)->where('available',0)
        //     ->first();
        // if ($existingBooking) {
        //     return response()->json(['error' => 'This  service already  booked  Please choose another or visit it after 2 hour'], 422);
        // }

        // Create the booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'address' => $request->address,
            // 'date' => $selectedDateTime,
            'name' => $request->name?? $user->name,
            'phone' => $request->phone?? $user->phone,
            'total_price' => $total_price,
            'status' => $request->has('status') ? $request->status : false,
            'booking_time'=>Carbon::now(),
        ]);
        if (!isServiceInUserSubscription($request->service_id)) {
            if($request->payment=='Tabby'){
                $items = collect([]);
                $items->push([
                    'title' => 'title',
                    'quantity' => 2,
                    'unit_price' => 20,
                    'category' => 'Clothes',
                ]);;

            $order_data = [
                'amount'=> 100,
                'currency' => 'SAR',
                'description'=> 'description',
                'full_name'=> $booking->user->name??'user_name',
                'buyer_phone'=>$booking->user->phone??'9665252123',
                'buyer_email' => 'card.success@tabby.ai',
                'address'=> 'Saudi Riyadh',
                'city' => 'Riyadh',
                'zip'=> '1234',
                'order_id'=>"$booking->id",
                'registered_since' => $booking->created_at,
                'loyalty_level'=> 0,
                'success-url'=> route('success-ur'),
                'cancel-url' => route('cancel-ur'),
                'failure-url' => route('failure-ur'),
                'items' =>  $items,
                ];

            $payment = $this->tabby->createSession($order_data);

            $id = $payment->id;

            $redirect_url = $payment->configuration->available_products->installments[0]->web_url;

            return  $redirect_url;
        }elseif($request->payment=='paylink'){


            // $client = new \Paylink\Client();
            // $client->setVendorId('APP_ID_1710162901464');
            // $client->setVendorSecret('f29394fd-37fd-3ee7-a4f7-ea6014a24146');
            // $client->setEnvironment('testing');
            //3199240300708865
            $client = new \Paylink\Client([
                'vendorId'  =>  'APP_ID_1123453311',
                'vendorSecret'  =>  '0662abb5-13c7-38ab-cd12-236e58f43766',

            ]);

             $data = [
                        'amount' => 5,
                        'callBackUrl' => route('paylink-result'),
                        'clientEmail' => 'test@gmail.com',
                        'clientMobile' => '0500000000',
                        'clientName' => 'Zaid Matooq',
                        'note' => 'This invoice is for VIP client.',
                        'orderNumber' => "$booking->id",
                        'products' => [
                            [
                                'description' => 'Brown Hand bag leather for ladies',
                                'imageSrc' => 'http://merchantwebsite.com/img/img1.jpg',
                                'price' => 150,
                                'qty' => 1,
                                'title' => 'ggg',
                            ],
                        ],
                    ];


            $response = $client->createInvoice($data);
        //  dd($response);
            return    $response['mobileUrl'];

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




        // Send notification when booking is created
        $adminUsers = User::where('roles_name', 'Admin')->get();
        foreach ($adminUsers as $adminUser) {
        Notification::send($adminUser, new BookingNotification($booking));
        }
        $user->notify(new AppUserBooking( $service));
        BookedEvent::dispatch( $service);
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

        $tabby_payemnt = $this->tabby->getSession($request->payment_id);
        if ($tabby_payemnt->status == "CLOSED") {

                $booking->paid == true;
                $booking->save();
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
    public function paylinkResult(Request $request)
    {
        dd($request);
       return  $this->tammara->calbackPayment($request);
    }
}
