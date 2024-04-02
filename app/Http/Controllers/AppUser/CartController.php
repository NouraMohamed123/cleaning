<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addItemToCart(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'service_id' => 'required|exists:services,id',
            'meters' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user_id = Auth::guard('app_users')->user()->id;


        $cart = Cart::where('user_id', $user_id)
            ->where('service_id', $request->service_id)
            ->first();

            if ($cart->isNotEmpty()) {

            $cart->meters = $request->meters != 0 ? $request->meters : $cart->meters + 1;
            $cart->save();
        } else {

            $cart = Cart::create([
                'user_id' => $user_id,
                'service_id' => $request->service_id,
                'meters' => $request->meters == 0 ? 1 : $request->meters,
            ]);
        }
        return response()->json([
            'status' => true,
            'quantity' => intval($cart->quantity),
            'message' => 'Item added to cart successfully',
        ], 200);
    }
    public function removeItemFromCart(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'service_id' => 'required|exists:services,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }
        $user_id = Auth::guard('app_users')->user()->id;

        $cart = Cart::where('user_id', $user_id)->where('service_id', $request->service_id)->first();

        if ($cart->quantity > 1) {
            $cart->quantity = $cart->quantity - 1;
            $cart->save();
            return response()->json([
                'status' => true,
                'quantity' => intval($cart->quantity),
                'message' => 'Item removed from cart successfully',
            ], 200);
        } else {
            $cart->delete();
            return response()->json([
                'status' => true,
                'quantity' => 0,
                'message' => 'Item removed from cart successfully',
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
